<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use Mvc5\Arg;
use Mvc5\Route\Route;
use RuntimeException;

class Add
{
    /**
     *
     */
    use Build;

    /**
     * @param Route $parent
     * @param array|Route $route
     * @param array $path
     * @param bool $start
     * @return array|Route
     * @throws RuntimeException
     */
    function __invoke(Route $parent, $route, array $path, $start = false)
    {
        if ($root = $parent->child($path[0])) {
            return $this($root, $route, array_slice($path, 1));
        }

        if (isset($path[1])) {
            throw new RuntimeException('Parent route not found: ' . $route[Arg::NAME]);
        }

        $route[Arg::NAME] = $path[0];

        $start && empty($route[Arg::ROUTE]) && isset($route[Arg::NAME])
            && $route[Arg::ROUTE] = $route[Arg::NAME];

        !$start && empty($route[Arg::ROUTE])
            && $route[Arg::ROUTE] = Arg::SEPARATOR . $path[0];

        $route = $this->definition($route);

        $parent->add($path[0], $route);

        return $route;
    }
}
