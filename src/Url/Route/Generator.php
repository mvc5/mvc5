<?php
/**
 *
 */

namespace Mvc5\Url\Route;

use Mvc5\Arg;
use Mvc5\Route\Route;
use Mvc5\Route\Definition\Build;
use Mvc5\Route\Definition\Compile;
use Mvc5\Url\Assemble;

trait Generator
{
    /**
     *
     */
    use Build;
    use Compile;

    /**
     * @var callable
     */
    protected $assembler;

    /**
     * @var array|Route
     */
    protected $route;

    /**
     * @var array
     */
    protected $options = [
        Arg::CANONICAL => true,
        Arg::FRAGMENT => '',
        Arg::HOST   => '',
        Arg::PORT   => '',
        Arg::QUERY => '',
        Arg::SCHEME => ''
    ];

    /**
     * @param array|Route $route
     * @param array $options
     * @param callable $assembler
     */
    function __construct($route = [], array $options = [], callable $assembler = null)
    {
        $this->options = $options + $this->options;
        $this->route = $route;
        $this->assembler = $assembler ?: new Assemble;
    }

    /**
     * @param string $scheme
     * @param string $host
     * @param string $port
     * @param string $path
     * @param array|\ArrayAccess $options
     * @return string
     */
    protected function assemble($scheme, $host, $port, $path, $options)
    {
        $canonical = !empty($options[Arg::CANONICAL]);

        return ($this->assembler)(
            $path,
            $options[Arg::QUERY],
            $options[Arg::FRAGMENT],
            $this->canonical($host, $options[Arg::HOST], $canonical),
            $this->canonical($scheme, $options[Arg::SCHEME], $canonical),
            $this->canonical($port, $options[Arg::PORT], $canonical)
        );
    }

    /**
     * @param $part
     * @param $default
     * @param $canonical
     * @return string
     */
    protected function canonical($part, $default, $canonical = false)
    {
        return $part ? (!$canonical && $part === $default ? '' : $part) : ($canonical ? $default : '');
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
     * @param array $params
     * @param array $options
     * @param string $path
     * @param Route $parent
     * @return string
     */
    protected function generate($name, array $params = [], array $options = [], $path = '', Route $parent = null)
    {
        $name = is_array($name) ? $name : explode(Arg::SEPARATOR, $name);

        $route = $parent ? $this->child($parent, $name[0]) : $this->url($this->config($name[0]));

        $path .= $this->compile($route->tokens(), $params, $route->defaults(), $this->wildcard($route));

        array_shift($name);

        return $name ? $this->generate($name, $params, $options, $path, $route) : $this->assemble(
            $route->scheme(), $route->host(), $route->port(), $path, $this->options($options)
        );
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
        return rtrim($this->generate($this->name($name), $params, $options), Arg::SEPARATOR) ?: Arg::SEPARATOR;
    }
}
