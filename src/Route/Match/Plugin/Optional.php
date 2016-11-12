<?php
/**
 *
 */

namespace Mvc5\Route\Match\Plugin;

use Mvc5\Arg;
use Mvc5\Route\Route;

trait Optional
{
    /**
     * @param Route $route
     * @param $name
     * @return bool
     */
    protected function optional(Route $route, $name)
    {
        return in_array($name, $route[Arg::OPTIONAL] ?: []);
    }
}
