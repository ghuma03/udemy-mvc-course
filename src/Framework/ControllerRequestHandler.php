<?php

declare(strict_types=1);

namespace Framework;

class ControllerRequestHandler implements RequestHandlerInterface {

    private Controller $controller;
    private string $action;
    private array $args;

    public function __construct(Controller $controller, string $action, array $args) {
        $this->controller = $controller;
        $this->action = $action;
        $this->args = $args;
    }

    public function handle(Request $request): Response {
        $this->controller->setRequest($request);
        return ($this->controller)->{$this->action}(...$this->args);
    }

}