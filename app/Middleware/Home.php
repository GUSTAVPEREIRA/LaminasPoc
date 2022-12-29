<?php

namespace App\Middleware;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Home Implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (! in_array($request->getUri()->getPath(), ['/', ''], true)) {
            return $handler->handle($request);
        }

        $response = new Response();
        $response->getBody()->write('Welcome POC Api using laminas-stratigility');

        return $response;
    }
}
