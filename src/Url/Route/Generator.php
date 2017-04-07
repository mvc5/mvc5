<?php
/**
 *
 */

namespace Mvc5\Url\Route;

use Mvc5\Arg;
use Mvc5\Http\Uri;
use Mvc5\Http\Uri\Config as HttpUri;
use Mvc5\Route\Route;
use Mvc5\Route\Definition\Build;
use Mvc5\Route\Definition\Compile;

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
     * @param $name
     * @return Route
     */
    protected function child(Route $parent, $name)
    {
        return $this->merge($parent, clone $this->route($parent->child($name)));
    }

    /**
     * @param $name
     * @return array|Route
     */
    protected function config($name)
    {
        return $name === $this->route[Arg::NAME] ? $this->route : $this->route->child($name);
    }

    /**
     * @param array|string $name
     * @param array $params
     * @param array $options
     * @param string $path
     * @param Route $parent
     * @return Uri
     */
    protected function generate($name, array $params = [], array $options = [], $path = '', Route $parent = null)
    {
        $name = is_array($name) ? $name : explode(Arg::SEPARATOR, $name);

        $route = $parent ? $this->child($parent, $name[0]) : $this->route($this->config($name[0]));

        $path .= $this->compile($route->tokens(), $params, $route->defaults(), $this->wildcard($route));

        array_shift($name);

        return $name ? $this->generate($name, $params, $options, $path, $route) :
            $this->uri($route->scheme(), $route->host(), $route->port(), $path, $options);
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
        return $name === $this->route[Arg::NAME] ? $name : $this->route[Arg::NAME] . Arg::SEPARATOR . $name;
    }

    /**
     * @param array|Route $route
     * @return Route|null
     */
    protected function route($route)
    {
        return $route instanceof Route && isset($route[Arg::TOKENS]) ? $route : $this->build($route, false);
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
     * @param null|string $name
     * @param array $params
     * @param array $options
     * @return string
     */
    function __invoke($name = null, array $params = [], array $options = [])
    {
        return $this->generate($this->name($name), $params, $options);
    }
}
