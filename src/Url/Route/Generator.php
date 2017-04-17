<?php
/**
 *
 */

namespace Mvc5\Url\Route;

use Mvc5\Arg;
use Mvc5\Http\Uri;
use Mvc5\Http\Uri\Config as HttpUri;
use Mvc5\Route\Definition\Build;
use Mvc5\Route\Definition\Compiler;
use Mvc5\Route\Route;

trait Generator
{
    /**
     *
     */
    use Build;

    /**
     * @var array
     */
    protected $generated = [];

    /**
     * @var array|\ArrayAccess
     */
    protected $route;

    /**
     * @var Uri
     */
    protected $uri;

    /**
     * @param array|\ArrayAccess $route
     * @param Uri $uri
     */
    function __construct($route, Uri $uri = null)
    {
        $this->route = $route;
        $this->uri = $uri ?: new HttpUri;
    }

    /**
     * @param Route $route
     * @param string $path
     * @return array
     */
    protected function append(Route $route, $path)
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
     * @param string $name
     * @return array|Route
     */
    protected function config($name)
    {
        return $name ? ($this->route[$name] ?? null) : null;
    }

    /**
     * @param $name
     * @return Route
     */
    protected function construct($name)
    {
        return $this->generated[$name] ?? $this->generated[$name] = $this->generate(explode(Arg::SEPARATOR, $name));
    }

    /**
     * @param array|string $name
     * @param array $path
     * @param Route $parent
     * @return Route
     */
    protected function generate(array $name, array $path = [], $parent = null)
    {
        return $this->resolve($this->match(array_shift($name), $parent), $name, $path);
    }

    /**
     * @param $host
     * @param $params
     * @return string
     */
    protected function hostname($host, array &$params)
    {
        return !is_array($host) ? $host : Compiler::compile($host[Arg::TOKENS], $params, $host[Arg::DEFAULTS] ?? []);
    }

    /**
     * @param string $name
     * @param Route $parent
     * @return Route
     */
    protected function match($name, Route $parent = null)
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
     * @param Route $route
     * @param array $name
     * @param array $path
     * @return Route
     */
    protected function next(Route $route, $name, $path)
    {
        return $name ? $this->generate($name, $path, $route) : $route->with(Arg::PATH, $path);
    }

    /**
     * @param Route $route
     * @param array $params
     * @param array $options
     * @return array
     */
    protected function options(Route $route, $params, array $options)
    {
        return $options + [
            Arg::SCHEME => $route->scheme(),
            Arg::HOST => $this->hostname($route->host(), $params),
            Arg::PORT => $route->port(),
            Arg::PATH => $this->path($route->path(), $params)
        ];
    }

    /**
     * @param array $segment
     * @param $params
     * @param string $path
     * @return string
     */
    protected function path(array $segment, $params, $path = '')
    {
        foreach($segment as $route) {
            $path .= Compiler::compile($route->tokens(), $params, $route->defaults(), $this->wildcard($route));
        }

        return $path;
    }

    /**
     * @param array|Route $route
     * @param array $name
     * @param array $path
     * @return null|Route
     */
    protected function resolve($route, $name, $path)
    {
        return $route ? $this->next($route, $name, $this->append($route, $path)) : null;
    }

    /**
     * @param array|Route $route
     * @return Route|null
     */
    protected function route($route)
    {
        return !$route || $route instanceof Route ? $route : $this->build($route, false);
    }

    /**
     * @param Route|null $route
     * @param array $params
     * @param array $options
     * @return null|Uri
     */
    protected function uri(Route $route = null, array $params = [], array $options = [])
    {
        return $route ? $this->uri->with($this->options($route, $params, $options)) : null;
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
        return $this->uri($this->construct($name), $params, $options);
    }
}
