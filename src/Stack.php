<?php

namespace Viloveul\Middleware;

use Viloveul\Middleware\Contracts\Stack as IStack;
use Psr\Http\Message\ResponseInterface as IResponse;
use Psr\Http\Server\MiddlewareInterface as IMiddleware;
use Viloveul\Middleware\Contracts\Collection as ICollection;
use Psr\Http\Message\ServerRequestInterface as IServerRequest;

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
     * @param callable    $handler
     * @param ICollection $collections
     */
    public function __construct(callable $handler, ICollection $collections)
    {
        $this->handler = $handler;
        $this->collections = $collections->all();
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
                return $this->processMiddleware($request, $middleware);
            }
        }
        return call_user_func($this->handler, $request);
    }

    /**
     * @param  IServerRequest $request
     * @param  IMiddleware    $middleware
     * @return mixed
     */
    protected function processMiddleware(IServerRequest $request, IMiddleware $middleware): IResponse
    {
        return $middleware->process($request, $this);
    }
}
