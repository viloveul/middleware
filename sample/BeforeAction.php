<?php

namespace ViloveulMiddlewareSample;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\ServerRequest;

class BeforeAction implements MiddlewareInterface
{
    /**
     * @param  ServerRequestInterface  $request
     * @param  RequestHandlerInterface $handler
     * @return mixed
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $request = new ServerRequest([], [], '/bar');
        return $handler->handle($request);
    }
}
