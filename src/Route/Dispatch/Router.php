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
     * @return mixed|Request
     */
    protected function dispatch($request)
    {
        return $this->result($request, $this->traverse($this->route, $request));
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
     * @param Route $route
     * @param Request $request
     * @return mixed|Request
     */
    protected function match($route, $request)
    {
        return ($this->match)($route, $request);
    }

    /**
     * @param $name
     * @param $parent
     * @return string
     */
    protected function name($name, $parent)
    {
        return !$parent ? $name : $parent . Arg::SEPARATOR . $name;
    }

    /**
     * @param Request $request
     * @param $result
     * @return mixed|Request
     */
    protected function result(Request $request, $result = null)
    {
        !$result &&
            $result = new NotFound;

        $result instanceof Error
            && $result = $request->with(Arg::ERROR, $result);

        return $result;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @return mixed|Request
     */
    protected function route($route, $request)
    {
        return $this->solve($this->match($route, $request));
    }

    /**
     * @param $request
     * @return mixed|Request
     */
    protected function solve($request)
    {
        return !$request instanceof Request || true === $request[Arg::MATCHED] ? $request :
            $this->traverse($request[Arg::ROUTE][Arg::CHILDREN] ?? [], $request, $request[Arg::ROUTE]);
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param string $name
     * @return mixed|Request
     */
    protected function step(Route $route, Request $request, $name)
    {
        return $this->route(
            $route->with(Arg::NAME, $this->name($this->key($route, $name), $request[Arg::NAME])), $request
        );
    }

    /**
     * @param array|\Iterator $routes
     * @param Request $request
     * @param null|Route $parent
     * @return mixed|Request
     */
    protected function traverse($routes, $request, $parent = null)
    {
        foreach($routes as $name => $route) {
            if ($match = $this->step($this->child($this->definition($route), $parent), $request, $name)) {
                return $match;
            }
        }

        return new NotFound;
    }

    /**
     * @param Request $request
     * @return mixed|Request
     */
    function __invoke(Request $request)
    {
        return $this->dispatch($request);
    }
}
