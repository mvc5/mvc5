<?php
/**
 *
 */

namespace Mvc5\View\Exception;

interface ViewException
{
    /**
     *
     */
    const VIEW = 'Exception\View';

    /**
     * @param callable $callable
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null);
}
