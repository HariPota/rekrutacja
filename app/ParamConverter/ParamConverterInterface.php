<?php

namespace App\ParamConverter;

use Symfony\Component\HttpFoundation\Request;

interface ParamConverterInterface
{
    /**
     * @template T of object
     * @param Request $request
     * @param class-string<T> $className
     * @return T
     * @throws \InvalidArgumentException
     */
    public function convert(Request $request, string $className): object;
}
