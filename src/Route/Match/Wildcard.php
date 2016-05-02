<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Route\Definition;
use Mvc5\Route\Route;

class Wildcard
{
   /**
     * @param Route $route
     * @param Definition $definition
     * @return Route
     */
    function __invoke(Route $route, Definition $definition)
    {
        if (!$definition->wildcard()) {
            return $route;
        }

        $params = $route->params();

        $parts  = explode(Arg::SEPARATOR, trim(substr($route->path(), $route->length()), Arg::SEPARATOR));

        for($i = 0, $n = count($parts); $i < $n; $i += 2) {
            if (!isset($parts[$i + 1]) || isset($params[$parts[$i]])) {
                continue;
            }

            $params[$parts[$i]] = $parts[$i + 1];
        }

        $route[Arg::PARAMS]  = $params;
        $route[Arg::MATCHED] = true;

        return $route;
    }
}
