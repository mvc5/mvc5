<?php
/**
 *
 */

namespace Mvc5\Route\Plugin;

use Mvc5\Route\Generator\GenerateRoute;
use Mvc5\Route\RouteService;

class Plugin
    implements RoutePlugin
{
    /**
     *
     */
    use RouteService;
    use GenerateRoute;

    /**
     * @param null|string $name
     * @param array $args
     * @return string
     */
    public function __invoke($name = null, array $args = [])
    {
        return $this->generate($name ?: $this->route()->name(), $name ? $args : $args + $this->route()->params());
    }
}
