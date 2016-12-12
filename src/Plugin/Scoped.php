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
     * @param $callable
     */
    function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * @return \Closure
     */
    function closure()
    {
        return $this->fromCallable($this->callable);
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
