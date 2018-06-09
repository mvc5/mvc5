<?php
/**
 *
 */

namespace Mvc5\Route\Match\Plugin;

use Mvc5\Arg;
use Mvc5\Route\Route;

use function in_array;

trait Optional
{
    /**
     * @param Route $route
     * @param string $name
     * @return bool
     */
    protected function optional(Route $route, string $name) : bool
    {
        return in_array($name, (array) $route[Arg::OPTIONAL]);
    }
}
