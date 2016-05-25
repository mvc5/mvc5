<?php
/**
 *
 */

namespace Mvc5\Route\Dispatch;

use Mvc5\Arg;
use Mvc5\Http\Error;
use Mvc5\Http\Error\NotFound;
use Mvc5\Http\Request;
use Mvc5\Plugin;
use Mvc5\Route\Route;
use Mvc5\Route\Request as RouteRequest;
use Mvc5\Route\Request\Config;

trait Router
{
    /**
     *
     */
    use Plugin;

    /**
     * @var string
     */
    protected $request = Config::class;

    /**
     * @var array|Route
     */
    protected $route;

    /**
     * @param array|Route $route
     * @param string $request
     */
    function __construct($route, $request = null)
    {
        $this->route = $route;

        $request && $this->request = $request;
    }

    /**
     * @param array|Route $route
     * @return Route
     */
    protected function definition($route)
    {
        return $this->call(Arg::ROUTE_GENERATOR, [Arg::ROUTE => $route]);
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function dispatch(Request $request)
    {
        return $this->route(new $this->request(clone $request), $this->routeDefinition($this->route));
    }

    /**
     * @param $route
     * @param $request
     * @return Request
     */
    protected function match($route, $request)
    {
        return $this->trigger([Arg::ROUTE_MATCH, Arg::ROUTE => $route, Arg::REQUEST => $request]);
    }

    /**
     * @return string
     */
    protected function name()
    {
        return $this->route[Arg::NAME];
    }

    /**
     * @param Request $request
     * @return Error|Request
     */
    protected function request(Request $request)
    {
        $result = $this->dispatch($request);

        !$result &&
            $result = new NotFound;

        $result instanceof Error
            && $request[Arg::ERROR] = $result;

        return $result instanceof Request ? $result : $request;
    }

    /**
     * @param RouteRequest $request
     * @param Route $route
     * @return Request
     */
    protected function route(RouteRequest $request, Route $route)
    {
        $request = $this->match($route, $request);

        if (!$request instanceof RouteRequest) {
            return $request;
        }

        !$request->name() && $request[Arg::NAME] = $route->name();

        if ($request->matched()) {
            return $request->request();
        }

        $parent = $request->name();

        foreach($route->children() as $name => $route) {
            $this->name() !== $parent &&
            $name = $parent . Arg::SEPARATOR . $name;

            if ($match = $this->route($request->with(Arg::NAME, $name), $this->routeDefinition($route))) {
                return $match;
            }
        }

        return null;
    }

    /**
     * @param array|Route $route
     * @return Route
     */
    protected function routeDefinition($route)
    {
        return $route instanceof Route && isset($route[Arg::REGEX])
            ? $route : $this->definition($route);
    }

    /**
     * @param Request $request
     * @return Request
     */
    function __invoke(Request $request)
    {
        return $this->request($request);
    }
}
