<?php

namespace Viloveul\Middleware\Contracts;

use Psr\Http\Server\MiddlewareInterface;

interface Delegator extends MiddlewareInterface
{
    /**
     * @param $handler
     */
    public function delegate($handler): void;

    /**
     * @param $callback
     */
    public static function make($callback): self;
}
