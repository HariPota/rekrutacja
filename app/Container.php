<?php

namespace App;

class Container
{
    /** @var array<string, string> */
    private array $bindings = [];

    /** @var array<string, object> */
    private array $instances = [];

    /**
     * @param string $abstract
     * @param string $concrete
     * @return void
     */
    public function bind(string $abstract, string $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    /**
     * @template T of object
     * @param class-string<T> $className
     * @return T
     * @throws \RuntimeException
     */
    public function get(string $className): object
    {
        if (isset($this->instances[$className])) {
            return $this->instances[$className];
        }

        $concrete = $this->bindings[$className] ?? $className;

        try {
            $reflection = new \ReflectionClass($concrete);
        } catch (\ReflectionException $e) {
            throw new \RuntimeException("Class {$concrete} not found", 0, $e);
        }

        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            $instance = new $concrete();
            $this->instances[$className] = $instance;

            return $instance;
        }

        $args = [];
        foreach ($constructor->getParameters() as $param) {
            $type = $param->getType();

            if (!$type instanceof \ReflectionNamedType || $type->isBuiltin()) {
                if ($param->isDefaultValueAvailable()) {
                    $args[] = $param->getDefaultValue();
                    continue;
                }

                throw new \RuntimeException("Cannot resolve parameter \${$param->getName()} in {$concrete}");
            }

            $args[] = $this->get($type->getName());
        }

        $instance = $reflection->newInstanceArgs($args);
        $this->instances[$className] = $instance;

        return $instance;
    }
}
