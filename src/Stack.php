<?php

namespace Viloveul\Middleware;

use Closure;
use Psr\Http\Message\ResponseInterface as IResponse;
use Psr\Http\Message\ServerRequestInterface as IServerRequest;
use Psr\Http\Server\MiddlewareInterface as IMiddleware;
use Viloveul\Middleware\Contracts\Stack as IStack;
use Viloveul\Middleware\Delegator;

class Stack implements IStack
{
    /**
     * @var array
     */
    protected $collections = [];

    /**
     * @var mixed
     */
    protected $handler;

    /**
     * @param Closure $handler
     * @param array   $collections
     */
    public function __construct(Closure $handler, array $collections = [])
    {
        $this->handler = $handler;
        $this->collections = $collections;
    }

    /**
     * @param  IServerRequest $request
     * @return mixed
     */
    public function __invoke(IServerRequest $request): IResponse
    {
        return $this->handle($request);
    }

    /**
     * @param IServerRequest $request
     */
    public function handle(IServerRequest $request): IResponse
    {
        if (!empty($this->collections)) {
            if ($middleware = array_shift($this->collections)) {
                if ($middleware instanceof IMiddleware) {
                    return $middleware->process($request, $this);
                } else {
                    return Delegator::make($middleware)->process($request, $this);
                }
            }
        }

        return call_user_func($this->handler);
    }
}
