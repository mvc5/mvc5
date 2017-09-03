<?php
/**
 *
 */

namespace Mvc5\Url\Route;

use Mvc5\Arg;
use Mvc5\Http\HttpUri;
use Mvc5\Http\Uri;
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
     * @param Uri|null $uri
     */
    function __construct($route, Uri $uri = null)
    {
        $this->route = $route;
        $this->uri = $uri ?: new HttpUri;
    }

    /**
     * @param Route $route
     * @param array $path
     * @return array
     */
    protected function append(Route $route, array $path) : array
    {
        $path[] = $route;
        return $path;
    }

    /**
     * @param Route $parent
     * @param array|Route $route
     * @return Route|null
     */
    protected function child(Route $parent, $route)
    {
        return $route ? $this->merge($parent, $this->route($route)) : null;
    }

    /**
     * @param string $name
     * @return array|Route|null
     */
    protected function config(string $name)
    {
        return $this->route[$name] ?? null;
    }

    /**
     * @param string $name
     * @return Route|null
     */
    protected function construct(string $name)
    {
        return $this->generated[$name] ?? $this->generated[$name] = $this->generate(explode(Arg::SEPARATOR, $name));
    }

    /**
     * @param array $name
     * @param array $path
     * @param Route|null $parent
     * @return Route|null
     */
    protected function generate(array $name, array $path = [], Route $parent = null)
    {
        return $this->resolve($this->match(array_shift($name), $parent), $name, $path);
    }

    /**
     * @param array|string|null $host
     * @param array $params
     * @return string|null
     */
    protected function hostname($host, array &$params)
    {
        return !is_array($host) ? $host : Compiler::compile($host[Arg::TOKENS], $params, $host[Arg::DEFAULTS] ?? []);
    }

    /**
     * @param string $name
     * @param Route|null $parent
     * @return Route|null
     */
    protected function match(string $name, Route $parent = null)
    {
        return $parent ? $this->child($parent, $parent->child($name)) : $this->route($this->config($name));
    }

    /**
     * @param Route $parent
     * @param Route $child
     * @param array $config
     * @return Route
     */
    protected function merge(Route $parent, Route $child, array $config = []) : Route
    {
        !$child->scheme()
            && $config[Arg::SCHEME] = $parent->scheme();

        !$child->host()
            && $config[Arg::HOST] = $parent->host();

        !$child->port()
            && $config[Arg::PORT] = $parent->port();

        return $config ? $child->with($config) : $child;
    }

    /**
     * @param Route $route
     * @param array $name
     * @param array $path
     * @return Route|null
     */
    protected function next(Route $route, array $name, array $path)
    {
        return $name ? $this->generate($name, $path, $route) : $route->with(Arg::PATH, $path);
    }

    /**
     * @param Route $route
     * @param array $params
     * @param array $options
     * @return array
     */
    protected function options(Route $route, array $params, array $options) : array
    {
        !isset($options[Arg::SCHEME])
            && $options[Arg::SCHEME] = $route->scheme();

        !isset($options[Arg::HOST])
            && $options[Arg::HOST] = $this->hostname($route->host(), $params);

        !isset($options[Arg::PORT])
            && $options[Arg::PORT] = $route->port();

        $options[Arg::PATH] = $this->path($route->path(), $params);

        return $options;
    }

    /**
     * @param array $segment
     * @param array $params
     * @param string $path
     * @return string
     */
    protected function path(array $segment, array $params, string $path = '') : string
    {
        /** @var Route $route */
        foreach($segment as $route) {
            $path .= Compiler::compile($route->tokens(), $params, $route->defaults(), $this->wildcard($route));
        }

        return $path;
    }

    /**
     * @param array|Route $route
     * @param array $name
     * @param array $path
     * @return Route|null
     */
    protected function resolve($route, array $name, array $path)
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
     * @return Uri|null
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
        return !$route->wildcard() ? null : function(string $path, array $params = []) {
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
     * @return Uri|null
     */
    function __invoke(string $name, array $params = [], array $options = [])
    {
        return $this->uri($this->construct($name), $params, $options);
    }
}
