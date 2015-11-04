<?php
/**
 *
 */

namespace Mvc5\Route\Generator;

interface RouteGenerator
{
    /**
     * @param string $name
     * @param array $args
     * @return string
     */
    function url($name, array $args = []);
}
