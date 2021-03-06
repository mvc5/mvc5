<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Closure;

class Scoped
    implements Gem\Scoped
{
    /**
     * @var callable
     */
    protected $callable;

    /**
     * @var bool|true
     */
    protected bool $scoped = true;

    /**
     * @param callable $callable
     * @param bool|true $scoped
     */
    function __construct(callable $callable, bool $scoped = true)
    {
        $this->callable = $callable;
        $this->scoped = $scoped;
    }

    /**
     * @return Closure
     */
    function closure() : Closure
    {
        return ($this->callable)();
    }

    /**
     * @return bool
     */
    function scoped() : bool
    {
        return $this->scoped;
    }
}
