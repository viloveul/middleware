<?php

namespace Viloveul\Middleware;

use Closure;
use Viloveul\Middleware\Delegator;
use Viloveul\Middleware\Contracts\Collection as ICollection;

class Collection implements ICollection
{
    /**
     * @var array
     */
    protected $collections = [];

    /**
     * @var mixed
     */
    protected $mapper;

    /**
     * @param $handler
     */
    public function add($handler): void
    {
        if ($handler instanceof Closure) {
            $this->collections[] = Delegator::make($handler);
        } else {
            $this->collections[] = $handler;
        }
    }

    /**
     * @return mixed
     */
    public function all(): array
    {
        if (is_callable($this->mapper)) {
            return array_map($this->mapper, $this->collections);
        } else {
            return $this->collections;
        }
    }

    public function count(): int
    {
        return count($this->collections);
    }

    /**
     * @param $callback
     */
    public function map(callable $callback): void
    {
        $this->mapper = $callback;
    }
}
