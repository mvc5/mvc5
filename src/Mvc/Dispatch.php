<?php
/**
 *
 */

namespace Mvc5\Mvc;

interface Dispatch
{
    /**
     *
     */
    const MVC = 'Mvc';

    /**
     *
     */
    const RESPONSE = 'Response';

    /**
     *
     */
    const ROUTE = 'Route';

    /**
     * @param callable $callable
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null);
}
