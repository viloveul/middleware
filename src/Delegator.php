<?php

namespace Viloveul\Middleware;

use Psr\Http\Message\ResponseInterface as IResponse;
use Psr\Http\Message\ServerRequestInterface as IServerRequest;
use Psr\Http\Server\RequestHandlerInterface as IRequestHandler;
use RuntimeException;
use Viloveul\Middleware\Contracts\Delegator as IDelegator;

class Delegator implements IDelegator
{
    /**
     * @var mixed
     */
    protected $handler;

    /**
     * @param $handler
     */
    public function delegate($handler): void
    {
        if (is_callable($handler)) {
            $this->handler = $handler;
        } else {
            throw new RuntimeException("Cannot process argument, argument must be callable");
        }
    }

    /**
     * @param  $callback
     * @return mixed
     */
    public static function make($callback): IDelegator
    {
        $delegator = new static;
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
