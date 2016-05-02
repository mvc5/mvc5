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
        if (!$route->wildcard()) {
            return $request;
        }

        $parts = explode(Arg::SEPARATOR, trim(substr($request->path(), $request->length()), Arg::SEPARATOR));

        for($i = 0, $n = count($parts); $i < $n; $i += 2) {
            if (!isset($parts[$i + 1])) {
                continue;
            }

            $request->attr($parts[$i], $parts[$i + 1]);
        }

        $request[Arg::MATCHED] = true;

        return $request;
    }
}
