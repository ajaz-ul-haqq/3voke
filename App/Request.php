<?php

namespace App;

class Request {

    private array $request = [];

    public function __construct()
    {
        $this->request = $_REQUEST;
    }

    public function has($key): bool
    {
        return array_key_exists($key, $this->request);
    }

    public function get($key)
    {
        return self::has($key) ? $this->request[$key] : null;
    }

    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function intercept(): static
    {
        return new $this;
    }

    public function all(): array
    {
        return $this->request;
    }
}