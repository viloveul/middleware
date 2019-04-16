<?php

namespace Viloveul\Middleware\Contracts;

use Closure;
use Psr\Http\Server\MiddlewareInterface;

interface Delegator extends MiddlewareInterface
{
    /**
     * @param Closure $handler
     */
    public function delegate(Closure $handler): void;

    /**
     * @param Closure $callback
     */
    public static function make(Closure $callback): self;
}
