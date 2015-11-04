<?php
/**
 *
 */

namespace Mvc5\Service\Resolver\Event;

interface Dispatcher
{
    /**
     * @param callable $callable
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null);
}
