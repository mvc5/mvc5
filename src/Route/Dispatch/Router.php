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
use Mvc5\Request\Request as _Request;
use Mvc5\Route\Route;
use Mvc5\Route\Request as RouteRequest;
use Mvc5\Route\Request\Config;

trait Router
{
    /**
     *
     */
    use Plugin;
    use Traverse;

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
     * @param Route $route
     * @return Request
     */
    protected function dispatch(Request $request, Route $route)
    {
        return $this->route($this->routeRequest($request, $route), $route);
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return Request
     */
    protected function match(Request $request, Route $route)
    {
        return $this->trigger([Arg::ROUTE_MATCH, Arg::ROUTE => $route, Arg::REQUEST => $request]);
    }

    /**
     * @param $request
     * @param $routes
     * @return Request|_Request
     */
    protected function matchRequest($request, $routes)
    {
        return !$request instanceof RouteRequest ? $request : (
            $request->matched() ? $request->request() : $this->traverse($request, $routes)
        );
    }

    /**
     * @param $name
     * @param $parent
     * @return string
     */
    protected function name($name, $parent)
    {
        return $this->route[Arg::NAME] === $parent ? $name : $parent . Arg::SEPARATOR . $name;
    }

    /**
     * @param Request $request
     * @return Error|NotFound|Request|_Request
     */
    protected function request(Request $request)
    {
        $result = $this->dispatch($request, $this->routeDefinition($this->route));

        !$result &&
            $result = new NotFound;

        $result instanceof Error
            && $request[Arg::ERROR] = $result;

        return $result instanceof Request ? $result : $request;
    }

    /**
     * @param RouteRequest $request
     * @param Route $route
     * @return Request|_Request
     */
    protected function route(RouteRequest $request, Route $route)
    {
        return $this->matchRequest($this->match($request, $route), $route->children());
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return RouteRequest
     */
    protected function routeRequest(Request $request, Route $route)
    {
        return new $this->request($request->with(Arg::NAME, $route->name()));
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
     * @return _Request
     */
    function __invoke(Request $request)
    {
        return $this->request($request);
    }
}
