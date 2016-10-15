<?php
/**
 *
 */

namespace Mvc5\Url\Route;

use Mvc5\Arg;
use Mvc5\Route\Route;
use Mvc5\Route\Definition\Assemble;
use Mvc5\Route\Definition\Build;
use Mvc5\Route\Definition\Compile;

trait Generator
{
    /**
     *
     */
    use Assemble;
    use Build;
    use Compile;

    /**
     * @var array|Route
     */
    protected $route;

    /**
     * @var array
     */
    protected $options = [
        Arg::HOST   => null,
        Arg::PORT   => null,
        Arg::SCHEME => null
    ];

    /**
     * @param array|Route $route
     * @param array $options
     * @param array $expressions
     */
    function __construct($route = [], array $options = [], array $expressions = [])
    {
        $this->route = $route;

        $expressions && $this->expressions = $expressions + $this->expressions;
        $options && $this->options = $options + $this->options;
    }

    /**
     * @param Route $parent
     * @param $name
     * @return Route
     */
    protected function child(Route $parent, $name)
    {
        return $this->merge($parent, clone $this->url($parent->child($name)));
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
     * @param array $args
     * @param array $options
     * @param string $path
     * @param Route $parent
     * @return string|void
     */
    protected function generate($name, array $args = [], array $options = [], $path = '', Route $parent = null)
    {
        $name = is_array($name) ? $name : explode(Arg::SEPARATOR, $name);

        $route = $parent ? $this->child($parent, $name[0]) : $this->url($this->config($name[0]));

        $path .= $this->compile($route->tokens(), $args, $route->defaults(), $route->wildcard());

        array_shift($name);

        return $name ? $this->generate($name, $args, $options, $path, $route) :
            $this->assemble($route->scheme(), $route->host(), $route->port(), $path, $this->options($options));
    }

    /**
     * @param Route $parent
     * @param Route $child
     * @return Route
     */
    protected function merge(Route $parent, Route $child)
    {
        !$child->scheme() && $parent->scheme()
            && $child[Arg::SCHEME] = $parent->scheme();

        !$child->host() && $parent->host()
            && $child[Arg::HOST] = $parent->host();

        !$child->port() && $parent->port()
            && $child[Arg::PORT] = $parent->port();

        return $child;
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
     * @param array $options
     * @return array
     */
    protected function options(array $options = [])
    {
        return $options + $this->options;
    }

    /**
     * @param array|Route $route
     * @return Route|null
     */
    protected function url($route)
    {
        return $route instanceof Route && isset($route[Arg::TOKENS]) ? $route : $this->build($route, false);
    }

    /**
     * @param null|string $name
     * @param array $args
     * @param array $options
     * @return string
     */
    function __invoke($name = null, array $args = [], array $options = [])
    {
        return rtrim($this->generate($this->name($name), $args, $options), Arg::SEPARATOR) ?: Arg::SEPARATOR;
    }
}
