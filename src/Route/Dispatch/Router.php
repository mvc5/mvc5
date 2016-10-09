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
     * @return RouteRequest
     */
    protected function routeRequest(Request $request)
    {
        return new $this->request($request);
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
     * @param RouteRequest $request
     * @param Route $route
     * @param string $name
     * @return Request
     */
    protected function step(RouteRequest $request, Route $route, $name)
    {
        return $this->route(
            $request->with(Arg::NAME, $this->name(is_string($name) ? $name : $route->name(), $request->name())), $route
        );
    }

    /**
     * @param RouteRequest $request
     * @param array|\Iterator $routes
     * @return Request|NotFound
     */
    protected function traverse(RouteRequest $request, $routes)
    {
        foreach($routes as $name => $route) {
            if ($match = $this->step($request, $this->routeDefinition($route), $name)) {
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
