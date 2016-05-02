<?php
/**
 *
 */

namespace Mvc5\Route\Router;

use Mvc5\Arg;
use Mvc5\Request\Request;
use Mvc5\Route\Route;
use Mvc5\Route\Request as RouteRequest;
use Mvc5\Route\Request\Config;
use Mvc5\Signal;

trait Router
{
    /**
     *
     */
    use Signal;

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
    protected abstract function definition($route);

    /**
     * @param RouteRequest $request
     * @param Route $route
     * @return Request
     */
    protected function dispatch(RouteRequest $request, Route $route)
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
            $request[Arg::NAME] = $this->name() === $parent ? $name : $parent . Arg::SEPARATOR . $name;

            if ($match = $this->dispatch(clone $request, $this->routeDefinition($route))) {
                return $match;
            }
        }

        return null;
    }

    /**
     * @param Route $route
     * @param RouteRequest $request
     * @return RouteRequest
     */
    protected abstract function match($route, $request);

    /**
     * @return string
     */
    protected function name()
    {
        return $this->route[Arg::NAME];
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
        return $this->dispatch(new $this->request(clone $request), $this->routeDefinition($this->route));
    }
}
