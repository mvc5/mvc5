<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Plugin;
use Mvc5\Service;

class Controller
{
    /**
     *
     */
    use Plugin;

    /**
     * @param $controller
     * @param array $args
     * @return callable|mixed|null|object
     */
    protected function action($controller, array $args = [])
    {
        return $controller ? $this->call($this->controller($this->resolve($controller)), $args) : null;
    }

    /**
     * @param $controller
     * @return mixed
     */
    protected function controller($controller)
    {
        $controller instanceof Service && !$controller->service()
            && $controller->service($this->service());

        return $controller;
    }

    /**
     * @param $controller
     * @return callable|null|object
     */
    protected function resolve($controller)
    {
        return is_string($controller) ? $this->plugin($controller) : $controller;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
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
