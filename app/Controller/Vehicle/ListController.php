<?php

namespace App\Controller\Vehicle;

use App\Controller\BaseController;
use Domain\Service\VehiclesReader;
use Persistence\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListController extends BaseController
{
    /**
     * @param int|null $id
     * @param Request|null $request
     * @return JsonResponse
     */
    public function list(?int $id = null, ?Request $request = null): JsonResponse
    {
        $request = $request ?? Request::createFromGlobals();

        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $offset = ($page - 1) * $limit;

        $sort = null;
        $sortDirection = 'asc';
        $sortParam = $request->query->get('sort');

        if ($sortParam) {
            $parts = explode('|', $sortParam);
            $sort = $parts[0];
            if (isset($parts[1])) {
                $sortDirection = in_array($parts[1], ['ascending', 'asc']) ? 'asc' : 'desc';
            }
        }

        try {
            $results = (new VehiclesReader(new VehicleRepository()))->getList($limit, $offset, $sort, $sortDirection);

            return $this->toJsonResponse($results);
        } catch (\Throwable $e) {
            return $this->toJsonResponse(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
