<?php
/**
 *
 */

namespace Mvc5\Plugin;

class Callback
    extends Scoped
{
    /**
     * @param \Closure $closure
     */
    function __construct(\Closure $closure)
    {
        parent::__construct($closure, false);
    }

    /**
     * @return \Closure
     */
    function closure() : \Closure
    {
        return $this->callable;
    }
}
