<?php

declare(strict_types=1);

namespace Framework;

class Request {

    public string $uri;
    public string $method;

    public function __construct(string $uri, string $method) {
        $this->uri = $uri;
        $this->method = $method;
    }

}