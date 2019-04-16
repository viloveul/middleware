<?php

namespace Viloveul\Middleware;

use Closure;
use Psr\Http\Message\ResponseInterface as IResponse;
use Viloveul\Middleware\Contracts\Delegator as IDelegator;
use Psr\Http\Message\ServerRequestInterface as IServerRequest;
use Psr\Http\Server\RequestHandlerInterface as IRequestHandler;

class Delegator implements IDelegator
{
    /**
     * @var mixed
     */
    protected $handler;

    /**
     * @param Closure $handler
     */
    public function delegate(Closure $handler): void
    {
        $this->handler = $handler;
    }

    /**
     * @param  Closure $callback
     * @return mixed
     */
    public static function make(Closure $callback): IDelegator
    {
        $delegator = new static();
        $delegator->delegate($callback);
        return $delegator;
    }

    /**
     * @param IServerRequest  $request
     * @param IRequestHandler $handler
     */
    public function process(IServerRequest $request, IRequestHandler $handler): IResponse
    {
        return call_user_func($this->handler, $request, $handler);
    }
}
