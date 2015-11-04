<?php
/**
 *
 */

namespace Mvc5\Mvc\Controller;

interface Dispatch
{
    /**
     * @param array|callable|object|string $controller
     * @param array $args
     * @return mixed
     */
    function __invoke($controller, array $args = []);
}
