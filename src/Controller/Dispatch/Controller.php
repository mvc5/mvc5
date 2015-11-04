<?php
/**
 *
 */

namespace Mvc5\Controller\Dispatch;

interface Controller
{
    /**
     *
     */
    const DISPATCH = 'Controller\Dispatch';

    /**
     * @param callable $callable
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null);
}
