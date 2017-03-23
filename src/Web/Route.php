<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Route\Dispatch\Router;

class Route
{
    /**
     *
     */
    use Router;

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return mixed|Response
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        $result = $this->request($request);

        if ($result instanceof Request) {
            return $next($result, $response);
        }

        !$result instanceof Response &&
            $result = $response->with(Arg::BODY, $result);

        return $next($request, $result);
    }
}
