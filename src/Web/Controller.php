<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Plugin;

class Controller
{
    /**
     *
     */
    use Plugin;

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    protected function action(Request $request, Response $response, callable $next)
    {
        $result = $this->call(
            $request[Arg::CONTROLLER], [Arg::REQUEST => $request, Arg::RESPONSE => $response, Arg::NEXT => $next]
        );

        if ($result instanceof Response) {
            return $result;
        }

        null !== $result
            && $response[Arg::BODY] = $result;

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        return $next($request, $this->action($request, $response, $next));
    }
}
