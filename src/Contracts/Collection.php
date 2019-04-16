<?php

namespace Viloveul\Middleware\Contracts;

use Countable;

interface Collection extends Countable
{
    /**
     * @param $handler
     */
    public function add($handler): void;

    public function all(): array;

    /**
     * @param $callback
     */
    public function map(callable $callback): void;
}
