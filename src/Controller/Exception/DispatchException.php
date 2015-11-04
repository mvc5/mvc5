<?php
/**
 *
 */

namespace Mvc5\Controller\Exception;

interface DispatchException
{
    /**
     *
     */
    const EXCEPTION = 'Controller\Exception';

    /**
     * @param callable $callable
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null);
}
