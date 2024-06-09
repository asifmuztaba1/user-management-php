<?php

namespace Asifmuztaba\UserManagement\Managers;

class ContainerManager
{
    private array $bindings = [];
    private array $instances = [];

    public function bind(string $key, callable $resolver)
    {
        $this->bindings[$key] = $resolver;
    }

    public function singleton(string $key, callable $resolver)
    {
        $this->instances[$key] = $resolver($this);
    }

    public function resolve(string $key)
    {
        if (isset($this->instances[$key])) {
            return $this->instances[$key];
        }

        if (isset($this->bindings[$key])) {
            return $this->bindings[$key]($this);
        }

        throw new \Exception("No binding found for key: $key");
    }
}

