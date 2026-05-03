<?php

declare(strict_types=1);

namespace Framework;

class MiddlewareRequestHandler implements RequestHandlerInterface {

    private array $middlewares;
    private ControllerRequestHandler $controller_handler;

    public function __construct(array $middlewares, ControllerRequestHandler $controller_handler) {
        $this->middlewares = $middlewares;
        $this->controller_handler = $controller_handler;
    }

    public function handle(Request $request): Response {
        $middleware = $this->middlewares[0];
        return $middleware->process($request, $this->controller_handler);
    }

}