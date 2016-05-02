<?php
/**
 *
 */

namespace Mvc5\Resolver;

use RuntimeException;

class Exception
{
    /**
     * @param $plugin
     * @throws RuntimeException
     */
    function __invoke($plugin)
    {
        throw new RuntimeException(
            'Unresolvable plugin: ' . (is_object($plugin) ? get_class($plugin) : (is_string($plugin) ? $plugin : null))
        );
    }
}
