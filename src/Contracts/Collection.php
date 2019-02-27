<?php

namespace Viloveul\Middleware\Contracts;

interface Collection
{
    /**
     * @param $handler
     */
    public function add($handler): void;

    public function all(): array;
}
