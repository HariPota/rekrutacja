<?php

namespace App\ParamConverter;

use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;

class JsonParamConverter implements ParamConverterInterface
{
    private SerializerInterface $serializer;

    public function __construct()
    {
        $this->serializer = SerializerBuilder::create()
            ->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())
            ->build();
    }

    /**
     * @template T of object
     * @param Request $request
     * @param class-string<T> $className
     * @return T
     * @throws \InvalidArgumentException
     */
    public function convert(Request $request, string $className): object
    {
        $content = $request->getContent();

        if (empty($content)) {
            throw new \InvalidArgumentException('Request body is empty');
        }

        try {
            return $this->serializer->deserialize($content, $className, 'json');
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException('Failed to parse request: ' . $e->getMessage(), 0, $e);
        }
    }
}
