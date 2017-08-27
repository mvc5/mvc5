<?php
/**
 *
 */

namespace Mvc5\Plugin;

class ScopedCall
    extends Call
{
    /**
     * @param callable $callable
     * @param array $args
     */
    function __construct(callable $callable, array $args = [])
    {
        parent::__construct(new Scoped($callable), $args);
    }
}
