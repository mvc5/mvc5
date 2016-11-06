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
        return $this->route($this->routeRequest($request->with(Arg::NAME, $route->name())), $route);
    }

    /**
     * @param Request $request
     * @param Route $route
     * @param null|Route $parent
     * @return Request
     */
    protected function match($request, $route, $parent = null)
    {
        return $this->call(Arg::ROUTE_MATCH, [Arg::REQUEST => $request, Arg::ROUTE => $route, Arg::PARENT => $parent]);
    }

    /**
     * @param $request
     * @param Route $route
     * @return Request|_Request
     */
    protected function matchRequest($request, Route $route)
    {
        return !$request instanceof RouteRequest ? $request : (
            $request->matched() ? $request->request() : $this->traverse($request, $route->children(), $route)
        );
    }

    /**
     * @param string $name
     * @param string $parent
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
        return $this->result($request, $this->dispatch($request, $this->routeDefinition($this->route)));
    }

    /**
     * @param Request $request
     * @param $result
     * @return Error|NotFound|Request|_Request
     */
    protected function result(Request $request, $result = null)
    {
        !$result &&
            $result = new NotFound;

        $result instanceof Error
            && ($request[Arg::ERROR] = $result)
                && $result = $request;

        return $result;
    }

    /**
     * @param RouteRequest $request
     * @param Route $route
     * @param null|Route $parent
     * @return Request|_Request
     */
    protected function route(RouteRequest $request, Route $route, Route $parent = null)
    {
        return $this->matchRequest($this->match($request, $route, $parent), $route);
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
     * @return RouteRequest
     */
    protected function routeRequest(Request $request)
    {
        return new $this->request($request);
    }

    /**
     * @param RouteRequest $request
     * @param Route $route
     * @param string $name
     * @param null|Route $parent
     * @return Request
     */
    protected function step(RouteRequest $request, Route $route, $name, $parent = null)
    {
        return $this->route(
            $request->with(Arg::NAME, $this->name(is_string($name) ? $name : $route->name(), $request->name())), $route, $parent
        );
    }

    /**
     * @param RouteRequest $request
     * @param array|\Iterator $routes
     * @param null|Route $parent
     * @return Request|NotFound
     */
    protected function traverse(RouteRequest $request, $routes, $parent = null)
    {
        foreach($routes as $name => $route) {
            if ($match = $this->step($request, $this->routeDefinition($route), $name, $parent)) {
                return $match;
            }
        }

        return new NotFound;
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
