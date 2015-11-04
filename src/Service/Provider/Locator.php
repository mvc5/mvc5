<?php
/**
 *
 */

namespace Mvc5\Service\Provider;

interface Locator
{
    /**
     *
     */
    const PROVIDER = 'Service\Provider';

    /**
     * @param callable $callable
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null);
}
