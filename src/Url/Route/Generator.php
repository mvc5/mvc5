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
     * @param array $path
     * @param $route
     * @return array
     */
    protected function append(array $path, $route)
    {
        $path[] = $route;
        return $path;
    }

    /**
     * @param Route $parent
     * @param Route $route
     * @return Route
     */
    protected function child($parent, $route)
    {
        return $route ? $this->merge($parent, $this->route($route)) : null;
    }

    /**
     * @param array $segment
     * @param $params
     * @param string $path
     * @return string
     */
    protected function combine(array $segment, $params, $path = '')
    {
        foreach($segment as $route) {
            $path .= $this->compile($route->tokens(), $params, $route->defaults(), $this->wildcard($route));
        }

        return $path;
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
     * @param array $path
     * @param Route $parent
     * @return Uri
     */
    protected function generate(array $name, array $params = [], array $options = [], array $path = [], $parent = null)
    {
        return $this->resolve($this->match(array_shift($name), $parent), $name, $params, $options, $path);
    }

    /**
     * @param string $name
     * @param Route $parent
     * @return Route|Uri
     */
    protected function match($name, $parent)
    {
        return $parent ? $this->child($parent, $parent->child($name)) : $this->route($this->config($name));
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
     * @param Route $route
     * @param array $name
     * @param array $params
     * @param array $options
     * @param array $path
     * @return Uri
     */
    protected function path(Route $route, $name, $params, $options, $path)
    {
        return $name ? $this->generate($name, $params, $options, $path, $route) :
            $this->uri($route->scheme(), $route->host(), $route->port(), $this->combine($path, $params), $options);
    }

    /**
     * @param Route|Uri $route
     * @param array $name
     * @param array $params
     * @param array $options
     * @param array $path
     * @return Uri
     */
    protected function resolve($route, $name, $params, $options, $path)
    {
        return $route ? $this->path($route, $name, $params, $options, $this->append($path, $route)) : $route;
    }

    /**
     * @param array|Route $route
     * @return Route|null
     */
    protected function route($route)
    {
        return !$route || ($route instanceof Route && isset($route[Arg::TOKENS])) ? $route : $this->build($route, false);
    }

    /**
     * @param string $scheme
     * @param string $host
     * @param string $port
     * @param string $path
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
