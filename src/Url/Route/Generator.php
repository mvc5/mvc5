<?php
/**
 *
 */

namespace Mvc5\Url\Route;

use Mvc5\Arg;
use Mvc5\Http\Uri;
use Mvc5\Http\Uri\Config as HttpUri;
use Mvc5\Route\Definition\Build;
use Mvc5\Route\Definition\Compile;
use Mvc5\Route\Route;

trait Generator
{
    /**
     *
     */
    use Build;
    use Compile;

    /**
     * @var array|Route
     */
    protected $route;

    /**
     * @var Uri
     */
    protected $uri;

    /**
     * @param array|Route $route
     * @param Uri $uri
     */
    function __construct($route, Uri $uri = null)
    {
        $this->route = $route;
        $this->uri = $uri ?: new HttpUri;
    }

    /**
     * @param Route $parent
     * @param Route $route
     * @return Route
     */
    protected function child($parent, $route)
    {
        return $this->next($parent, $route);
    }

    /**
     * @param string $name
     * @return array|Route
     */
    protected function config($name)
    {
        return $name === $this->route[Arg::NAME] ? $this->route : null;
    }

    /**
     * @param array|string $name
     * @param array $params
     * @param array $options
     * @param string $path
     * @param Route $parent
     * @return Uri
     */
    protected function generate(array $name, array $params = [], array $options = [], $path = '', $parent = null)
    {
        return $this->solve($this->resolve(array_shift($name), $parent), $name, $params, $options, $path);
    }

    /**
     * @param Route $parent
     * @param Route $child
     * @param array $config
     * @return Route
     */
    protected function merge(Route $parent, Route $child, array $config = [])
    {
        !$child->scheme() && $parent->scheme()
            && $config[Arg::SCHEME] = $parent->scheme();

        !$child->host() && $parent->host()
            && $config[Arg::HOST] = $parent->host();

        !$child->port() && $parent->port()
            && $config[Arg::PORT] = $parent->port();

        return $config ? $child->with($config) : $child;
    }

    /**
     * @param string $name
     * @return string
     */
    protected function name($name)
    {
        return !$name || $name === $this->route[Arg::NAME] ? $name : $this->route[Arg::NAME] . Arg::SEPARATOR . $name;
    }

    /**
     * @param Route $parent
     * @param Route $route
     * @return null
     */
    protected function next($parent, $route)
    {
        return $route ? $this->merge($parent, $this->route($route)) : null;
    }

    /**
     * @param Route $route
     * @param array $name
     * @param array $params
     * @param array $options
     * @param string $path
     * @return Uri
     */
    protected function path(Route $route, $name, $params, $options, $path = '')
    {
        return $name ? $this->generate($name, $params, $options, $path, $route) :
            $this->uri($route->scheme(), $route->host(), $route->port(), $path, $options);
    }

    /**
     * @param $name
     * @param Route $parent
     * @return Route|Uri
     */
    protected function resolve($name, $parent)
    {
        return $parent ? $this->step($parent, $name) : $this->route($this->config($name));
    }

    /**
     * @param array|Route $route
     * @return Route|null
     */
    protected function route($route)
    {
        return !$route || ($route instanceof Route && isset($route[Arg::TOKENS])) ? $route :
            $this->build($route, false);
    }

    /**
     * @param Route $route
     * @param $params
     * @return string
     */
    protected function segment(Route $route, $params)
    {
        return $this->compile($route->tokens(), $params, $route->defaults(), $this->wildcard($route));
    }

    /**
     * @param Route|Uri $route
     * @param array $name
     * @param array $params
     * @param array $options
     * @param string $path
     * @return Uri
     */
    protected function solve($route, $name, $params, $options, $path)
    {
        return !$route || $route instanceof Uri ? $route :
            $this->path($route, $name, $params, $options, $path . $this->segment($route, $params));
    }

    /**
     * @param Route $parent
     * @param $name
     * @return Route
     */
    protected function step(Route $parent, $name)
    {
        return $this->child($parent, $parent->child($name));
    }

    /**
     * @param $scheme
     * @param $host
     * @param $port
     * @param $path
     * @param array $options
     * @return Uri
     */
    protected function uri($scheme, $host, $port, $path, array $options = [])
    {
        return $this->uri->with(
            [Arg::HOST => $host, Arg::PATH => $path, Arg::PORT => $port, Arg::SCHEME => $scheme] + $options
        );
    }

    /**
     * @param Route $route
     * @return \Closure|null
     */
    protected function wildcard(Route $route)
    {
        return !$route->wildcard() ? null : function($path, array $params = []) {
            foreach($params as $key => $value) {
                null !== $value && $path .= Arg::SEPARATOR . $key . Arg::SEPARATOR . $value;
            }

            return $path;
        };
    }

    /**
     * @param string $name
     * @param array $params
     * @param array $options
     * @return string
     */
    function __invoke($name, array $params = [], array $options = [])
    {
        return $this->generate(explode(Arg::SEPARATOR, $this->name($name)), $params, $options);
    }
}
