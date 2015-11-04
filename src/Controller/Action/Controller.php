<?php
/**
 *
 */

namespace Mvc5\Controller\Action;

interface Controller
{
    /**
     * @param callable $callable
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null);
}
