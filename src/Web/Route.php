<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Route\Dispatch\Router;

use const Mvc5\BODY;

final class Route
{
    /**
     *
     */
    use Router;

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response|mixed
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        $result = $this->dispatch($request);

        if ($result instanceof Request) {
            return $next($result, $response);
        }

        !$result instanceof Response &&
            $result = $response->with(BODY, $result);

        return $next($request, $result);
    }
}
