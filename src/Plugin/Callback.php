<?php
/**
 *
 */

namespace Mvc5\Plugin;

class Callback
    extends Scoped
{
    /**
     * @return \Closure
     */
    function closure()
    {
        return $this->callable;
    }
}
