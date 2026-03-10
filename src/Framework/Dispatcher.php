<?php

namespace Framework;

class Dispatcher {

    private Router $router;

    public function __construct(Router $router) {
        $this->router = $router;
    }

}