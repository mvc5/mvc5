<?php
/**
 *
 */

namespace Mvc5\Route\Match\Wildcard;

use Mvc5\Route\Definition\Definition;
use Mvc5\Route\Route;

class Wildcard
    implements MatchWildcard
{
   /**
     * @param Route $route
     * @param Definition $definition
     * @return Route
     */
    public function __invoke(Route $route, Definition $definition)
    {
        if (!$definition->wildcard()) {
            return $route;
        }

        $params = $route->params();

        $parts  = explode('/', trim(substr($route->path(), $route->length()), '/'));

        for($i = 0, $n = count($parts); $i < $n; $i += 2) {
            if (!isset($parts[$i + 1]) || isset($params[$parts[$i]])) {
                continue;
            }

            $params[$parts[$i]] = $parts[$i + 1];
        }

        $route->set(Route::PARAMS,  $params);
        $route->set(Route::MATCHED, true);

        return $route;
    }
}
