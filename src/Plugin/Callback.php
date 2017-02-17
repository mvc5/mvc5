<?php
/**
 *
 */

namespace Mvc5\Plugin;

class Callback
    extends Scoped
{
    /**
     * @param $callable
     */
    function __construct(callable $callable)
    {
        parent::__construct($callable, false);
    }

    /**
     * @return \Closure
     */
    function closure()
    {
        return $this->callable;
    }
}
