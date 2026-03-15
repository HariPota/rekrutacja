<?php
require_once './vendor/autoload.php';

Dotenv\Dotenv::createImmutable(__DIR__)->load();

use App\Container;
use App\Controller\Vehicle\CreateController;
use App\Controller\Vehicle\DeleteController;
use App\Controller\Vehicle\ListController;
use App\Controller\Vehicle\PageController;
use App\Controller\Vehicle\UpdateController;
use App\ParamConverter\JsonParamConverter;
use App\ParamConverter\ParamConverterInterface;
use Domain\Repository\VehicleRepositoryInterface;
use Persistence\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\{
    Exception\MethodNotAllowedException,
    Exception\ResourceNotFoundException,
    Matcher\UrlMatcher,
    RequestContext,
    Route,
    RouteCollection,
};

try {
    $container = new Container();
    $container->bind(VehicleRepositoryInterface::class, VehicleRepository::class);
    $container->bind(ParamConverterInterface::class, JsonParamConverter::class);

    $routes = new RouteCollection();
    $routes->add('index', new Route(
        path: '/vehicles',
        defaults: ['controller' => PageController::class, 'method' => 'index'],
        methods: ['GET'],
    ));
    $routes->add('list', new Route(
        path: '/vehicles/list',
        defaults: ['controller' => ListController::class, 'method' => 'list'],
        methods: ['GET'],
    ));
    $routes->add('create', new Route(
        path: '/vehicles/create',
        defaults: ['controller' => CreateController::class, 'method' => 'create'],
        methods: ['POST'],
    ));
    $routes->add('update', new Route(
        path: '/vehicles/update/{id}',
        defaults: ['controller' => UpdateController::class, 'method' => 'update'],
        requirements: ['id' => '[0-9]+'],
        methods: ['POST'],
    ));
    $routes->add('delete', new Route(
        path: '/vehicles/delete/{id}',
        defaults: ['controller' => DeleteController::class, 'method' => 'delete'],
        requirements: ['id' => '[0-9]+'],
        methods: ['POST'],
    ));

    $request = Request::createFromGlobals();

    $context = new RequestContext();
    $context->fromRequest($request);

    $matcher = new UrlMatcher($routes, $context);
    $parameters = $matcher->match($context->getPathInfo());

    $controller = $container->get($parameters['controller']);
    $action = $parameters['method'];

    $args = [];
    $reflection = new ReflectionMethod($controller, $action);
    foreach ($reflection->getParameters() as $param) {
        $type = $param->getType();
        $typeName = $type instanceof ReflectionNamedType ? $type->getName() : null;

        if ($typeName === Request::class) {
            $args[] = $request;
        } elseif ($param->getName() === 'id' && isset($parameters['id'])) {
            $args[] = (int) $parameters['id'];
        }
    }

    $response = $controller->$action(...$args);
    $response->send();
} catch (ResourceNotFoundException $e) {
    (new Response(content: $e->getMessage(), status: 404))->send();
} catch (MethodNotAllowedException $e) {
    (new Response(content: 'Method Not Allowed', status: 405))->send();
} catch (Throwable $e) {
    (new Response(content: $e->getMessage(), status: 500))->send();
}
