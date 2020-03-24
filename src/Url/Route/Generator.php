<?php
/**
 *
 */

namespace Mvc5\Url\Route;

use Mvc5\Http\HttpUri;
use Mvc5\Http\Uri;
use Mvc5\Route\Config;
use Mvc5\Route\Definition\Build;
use Mvc5\Route\Definition\Compiler;
use Mvc5\Route\Route;
use Throwable;

use function array_shift;
use function explode;
use function is_array;

use const Mvc5\{ DEFAULTS, HOST, PATH, PORT, SCHEME, SEPARATOR, TOKENS };

trait Generator
{
    /**
     *
     */
    use Build;

    /**
     * @var array
     */
    protected array $generated = [];

    /**
     * @var Route
     */
    protected Route $route;

    /**
     * @var Uri
     */
    protected Uri $uri;

    /**
     * @param array|Route $route
     * @param Uri|null $uri
     */
    function __construct($route, Uri $uri = null)
    {
        $this->route = is_array($route) ? new Config($route) : $route;
        $this->uri = $uri ?? new HttpUri;
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
     * @throws Throwable
     */
    protected function child(Route $parent, $route) : ?Route
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
     * @throws Throwable
     */
    protected function construct(string $name) : ?Route
    {
        return $this->generated[$name] ?? $this->generated[$name] = $this->generate(explode(SEPARATOR, $name));
    }

    /**
     * @param array $name
     * @param array $path
     * @param Route|null $parent
     * @return Route|null
     * @throws Throwable
     */
    protected function generate(array $name, array $path = [], Route $parent = null) : ?Route
    {
        return $this->resolve($this->match(array_shift($name), $parent), $name, $path);
    }

    /**
     * @param array|string|null $host
     * @param array $params
     * @return string|null
     * @throws Throwable
     */
    protected function hostname($host, array &$params) : ?string
    {
        return !is_array($host) ? $host : Compiler::compile($host[TOKENS], $params, $host[DEFAULTS] ?? []);
    }

    /**
     * @param string $name
     * @param Route|null $parent
     * @return Route|null
     * @throws Throwable
     */
    protected function match(string $name, Route $parent = null) : ?Route
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
            && $config[SCHEME] = $parent->scheme();

        !$child->host()
            && $config[HOST] = $parent->host();

        !$child->port()
            && $config[PORT] = $parent->port();

        return $config ? $child->with($config) : $child;
    }

    /**
     * @param Route $route
     * @param array $name
     * @param array $path
     * @return Route|null
     * @throws Throwable
     */
    protected function next(Route $route, array $name, array $path) : ?Route
    {
        return $name ? $this->generate($name, $path, $route) : $route->with(PATH, $path);
    }

    /**
     * @param Route $route
     * @param array $params
     * @param array $options
     * @return array
     * @throws Throwable
     */
    protected function options(Route $route, array $params, array $options) : array
    {
        !isset($options[SCHEME])
            && $options[SCHEME] = $route->scheme();

        !isset($options[HOST])
            && $options[HOST] = $this->hostname($route->host(), $params);

        !isset($options[PORT])
            && $options[PORT] = $route->port();

        $options[PATH] = $this->path($route->path(), $params);

        return $options;
    }

    /**
     * @param array $segment
     * @param array $params
     * @param string $path
     * @return string
     * @throws Throwable
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
     * @throws Throwable
     */
    protected function resolve($route, array $name, array $path) : ?Route
    {
        return $route ? $this->next($route, $name, $this->append($route, $path)) : null;
    }

    /**
     * @param array|Route $route
     * @return Route|null
     * @throws Throwable
     */
    protected function route($route) : ?Route
    {
        return !$route || $route instanceof Route ? $route : $this->build($route, false);
    }

    /**
     * @param Route|null $route
     * @param array $params
     * @param array $options
     * @return Uri|null
     * @throws Throwable
     */
    protected function uri(Route $route = null, array $params = [], array $options = []) : ?Uri
    {
        return $route ? $this->uri->with($this->options($route, $params, $options)) : null;
    }

    /**
     * @param Route $route
     * @return \Closure|null
     */
    protected function wildcard(Route $route) : ?\Closure
    {
        return !$route->wildcard() ? null : function(string $path, array $params = []) {
            foreach($params as $key => $value) {
                null !== $value && $path .= SEPARATOR . $key . SEPARATOR . $value;
            }

            return $path;
        };
    }

    /**
     * @param string $name
     * @param array $params
     * @param array $options
     * @return Uri|null
     * @throws Throwable
     */
    function __invoke(string $name, array $params = [], array $options = []) : ?Uri
    {
        return $this->uri($this->construct($name), $params, $options);
    }
}
