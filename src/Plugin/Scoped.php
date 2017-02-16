<?php
/**
 *
 */

namespace Mvc5\Plugin;

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
    protected $scoped;

    /**
     * @param $callable
     * @param bool|true $scoped
     */
    function __construct(callable $callable, $scoped = true)
    {
        $this->callable = $callable;
        $this->scoped = $scoped;
    }

    /**
     * @return \Closure
     */
    function closure()
    {
        return $this->fromCallable($this->callable);
    }

    /**
     * @return bool
     */
    function scoped()
    {
        return $this->scoped;
    }

    /**
     * @param callable $callable
     * @return \Closure
     */
    protected function fromCallable($callable)
    {
        return $callable();
    }
}
