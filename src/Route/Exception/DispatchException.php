<?php
/**
 *
 */

namespace Mvc5\Route\Exception;

interface DispatchException
{
    /**
     *
     */
    const EXCEPTION = 'Route\Exception';

    /**
     * @param callable $callable
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null);
}
