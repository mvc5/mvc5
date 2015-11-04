<?php
/**
 *
 */

namespace Mvc5\Route\Plugin;

interface RoutePlugin
{
    /**
     * @param null|string $name
     * @param array $args
     * @return string
     */
    function __invoke($name = null, array $args = []);
}
