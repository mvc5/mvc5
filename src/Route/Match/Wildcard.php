<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Route\Route;
use Mvc5\Route\Request;

class Wildcard
{
   /**
     * @param Request $request
     * @param Route $route
     * @return Request
     */
    function __invoke(Request $request, Route $route)
    {
        if ($request->matched() || !$route->wildcard()) {
            return $request;
        }

        $params = $request[Arg::PARAMS];
        $path   = trim(substr($request->path(), $request->length()), Arg::SEPARATOR);
        $parts  = explode(Arg::SEPARATOR, $path);

        $n = count($parts);

        if (!$path || $n < 2) {
            return null;
        }

        for($i = 0; $i < $n; $i += 2) {
            if (!isset($parts[$i + 1]) || isset($params[$parts[$i]])) {
                continue;
            }

            $params[$parts[$i]] = $parts[$i + 1];
        }

        $request[Arg::MATCHED] = true;
        $request[Arg::PARAMS]  = $params;

        return $request;
    }
}
