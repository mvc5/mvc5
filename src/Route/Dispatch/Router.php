<?php
/**
 *
 */

namespace Mvc5\Route\Dispatch;

use Mvc5\Arg;
use Mvc5\Http\Error;
use Mvc5\Http\Error\NotFound;
use Mvc5\Http\Request;
use Mvc5\Route\Route;

trait Router
{
    /**
     * @var callable
     */
    protected $generator;

    /**
     * @var callable
     */
    protected $match;

    /**
     * @var array|Route
     */
    protected $route;

    /**
     * @param callable $match
     * @param callable $generator
     * @param array|Route $route
     */
    function __construct(callable $match, callable $generator, $route)
    {
        $this->generator = $generator;
        $this->match = $match;
        $this->route = $route;
    }

    /**
     * @param Route $parent
     * @param null|Route $route
     * @return Route
     */
    protected function child(Route $route, $parent)
    {
        return $route->with(Arg::PARENT, $parent);
    }

    /**
     * @param array|Route $route
     * @return Route
     */
    protected function definition($route)
    {
        return $route instanceof Route && isset($route[Arg::REGEX])
            ? $route : ($this->generator)($route);
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return Request
     */
    protected function dispatch(Request $request, Route $route)
    {
        return $this->route($request->with(Arg::NAME, $route->name()), $route);
    }

    /**
     * @param Route $route
     * @param $name
     * @return string
     */
    protected function key(Route $route, $name)
    {
        return is_string($name) ? $name : $route->name();
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return Request
     */
    protected function match($request, $route)
    {
        return ($this->match)($route, $request);
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
     * @return Error|NotFound|Request
     */
    protected function request($request)
    {
        return $this->result($request, $this->dispatch($request, $this->definition($this->route)));
    }

    /**
     * @param Request $request
     * @param $result
     * @return Error|NotFound|Request
     */
    protected function result($request, $result = null)
    {
        !$result &&
            $result = new NotFound;

        $result instanceof Error
            && ($request[Arg::ERROR] = $result)
                && $result = $request;

        return $result;
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return Request
     */
    protected function route($request, $route)
    {
        return $this->routeRequest($this->match($request, $route), $route);
    }

    /**
     * @param $request
     * @param Route $route
     * @return Request
     */
    protected function routeRequest($request, Route $route)
    {
        return !$request instanceof Request ? $request : (
            $request[Arg::ROUTE] ? $request : $this->traverse($request, $route->children(), $route)
        );
    }

    /**
     * @param Request $request
     * @param Route $route
     * @param string $name
     * @return Request
     */
    protected function step(Request $request, Route $route, $name)
    {
        return $this->route(
            $request->with(Arg::NAME, $this->name($this->key($route, $name), $request[Arg::NAME])), $route
        );
    }

    /**
     * @param Request $request
     * @param array|\Iterator $routes
     * @param null|Route $parent
     * @return Request|NotFound
     */
    protected function traverse($request, $routes, $parent = null)
    {
        foreach($routes as $name => $route) {
            if ($match = $this->step($request, $this->child($this->definition($route), $parent), $name)) {
                return $match;
            }
        }

        return new NotFound;
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
