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
     * @param array $params
     * @param string $path
     * @return string
     */
    protected function append(Route $route, $params, $path)
    {
        return $path . $this->compile($route->tokens(), $params, $route->defaults(), $this->wildcard($route));
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
     * @param array|string $name
     * @param array $params
     * @param array $options
     * @param string $path
     * @param Route $parent
     * @return Uri
     */
    protected function generate(array $name, array $params = [], array $options = [], $path = '', $parent = null)
    {
        return $this->resolve($this->match(array_shift($name), $parent), $name, $params, $options, $path);
    }

    /**
     * @param string $name
     * @param Route $parent
     * @return Route|Uri
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
     * @param array $options
     * @return array
     */
    protected function options(Route $route, array $options)
    {
        return [Arg::SCHEME => $route->scheme(), Arg::HOST => $route->host(), Arg::PORT => $route->port()] + $options;
    }

    /**
     * @param Route $route
     * @param array $name
     * @param array $params
     * @param array $options
     * @param string $path
     * @return Uri
     */
    protected function path(Route $route, $name, $params, $options, $path)
    {
        return $name ? $this->generate($name, $params, $options, $path, $route) :
            $this->uri($path, $this->options($route, $options));
    }

    /**
     * @param Route|Uri $route
     * @param array $name
     * @param array $params
     * @param array $options
     * @param string $path
     * @return Uri
     */
    protected function resolve($route, $name, $params, $options, $path)
    {
        return $route ? $this->path($route, $name, $params, $options, $this->append($route, $params, $path)) : null;
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
     * @param string $path
     * @param array $options
     * @return Uri
     */
    protected function uri($path, array $options = [])
    {
        return $this->uri->with([Arg::PATH => $path] + $options);
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
        return $this->generate(explode(Arg::SEPARATOR, $name), $params, $options);
    }
}
