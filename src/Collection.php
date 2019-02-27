<?php

namespace Viloveul\Middleware;

use Closure;
use Viloveul\Middleware\Contracts\Collection as ICollection;
use Viloveul\Middleware\Delegator;

class Collection implements ICollection
{
    /**
     * @var array
     */
    protected $collections = [];

    /**
     * @param $handler
     */
    public function add($handler): void
    {
        if ($handler instanceof Closure) {
            $this->collections[] = Delegator::make(
                $handler->bindTo($this, $this)
            );
        } else {
            $this->collections[] = $handler;
        }
    }

    /**
     * @return mixed
     */
    public function all(): array
    {
        return $this->collections;
    }
}
