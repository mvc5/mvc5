<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Plugins\Service;

class Controller
{
    /**
     *
     */
    use Service;

    /**
     * @param $controller
     * @param array $args
     * @return callable|mixed|null|object
     */
    protected function action($controller, array $args = [])
    {
        return $controller ? $this->call($controller, $args) : null;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return mixed|Response
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        $result = $this->action(
            $request[Arg::CONTROLLER], [Arg::REQUEST => $request, Arg::RESPONSE => $response, Arg::NEXT => $next]
        );

        if ($result instanceof Response) {
            return $next($request, $result);
        }

        null !== $result
            && $response[Arg::BODY] = $result;

        return $next($request, $response);
    }
}
