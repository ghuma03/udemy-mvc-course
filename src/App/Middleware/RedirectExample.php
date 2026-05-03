<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Request;
use Framework\Response;
use Framework\RequestHandlerInterface;
use Framework\MiddlewareInterface;

class RedirectExample implements MiddlewareInterface {

    private Response $response;

    public function __construct(Response $response) {
        $this->response = $response;
    }

    public function process(Request $request, RequestHandlerInterface $next): Response {
        $this->response->redirect("/products/index");
        return $this->response;
    }

}