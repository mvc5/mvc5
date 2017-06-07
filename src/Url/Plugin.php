<?php
/**
 *
 */

namespace Mvc5\Url;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Uri;

class Plugin
{
    /**
     * @var bool|false
     */
    protected $absolute = false;

    /**
     * @var callable
     */
    protected $assembler;

    /**
     * @var callable
     */
    protected $generator;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var array|Uri
     */
    protected $uri;

    /**
     * @param Request $request
     * @param callable $generator
     * @param callable $assembler
     * @param bool|false $absolute
     */
    function __construct(Request $request, callable $generator, callable $assembler = null, $absolute = false)
    {
        $this->absolute = $absolute;
        $this->assembler = $assembler ?: new Assemble;
        $this->generator = $generator;
        $this->name = $request[Arg::NAME];
        $this->uri = $request[Arg::URI];

        $this->params[$this->name] = (array) $request[Arg::PARAMS];

        $this->parent($request, $request[Arg::PARENT]);
    }

    /**
     * @param array|Uri $config
     * @param array $options
     * @return array|Uri
     */
    protected function absolute($config, array $options = [])
    {
        if (!$this->absolute && empty($config[Arg::ABSOLUTE])) {
            return $config;
        }

        !isset($config[Arg::SCHEME]) &&
            $options[Arg::SCHEME] = $this->uri[Arg::SCHEME];

        !isset($config[Arg::PORT]) &&
            $options[Arg::PORT] = $this->uri[Arg::PORT];

        !isset($config[Arg::HOST]) &&
            $options[Arg::HOST] = $this->uri[Arg::HOST];

        return !$options ? $config : ($config instanceof Uri ? $config->with($options) : $options + $config);
    }

    /**
     * @param string|Uri $route
     * @param array|string $query
     * @param string $fragment
     * @param array $options
     * @return mixed
     */
    protected function assemble($route, $query = '', $fragment = '', array $options = [])
    {
        return $route ? ($this->assembler)($route, $query, $fragment, $options) : null;
    }

    /**
     * @param array|string|Uri $route
     * @param array|string $query
     * @param string $fragment
     * @param array $options
     * @return null|string
     */
    protected function create($route, $query = '', $fragment = '', array $options = [])
    {
        return $route instanceof Uri ? $this->uri($route) :
            $this->uri($this->route((array) $route, $this->options($query, $fragment, $options)));
    }

    /**
     * @param string $name
     * @param array $params
     * @param array $options
     * @return Uri
     */
    protected function generate($name, $params, $options)
    {
        return $name[0] === Arg::SEPARATOR ? null : ($this->generator)($name, $this->params($name, $params), $options);
    }

    /**
     * @param int $pos
     * @param string $name
     * @return array
     */
    protected function match($pos, $name)
    {
        return !$pos ? [] : $this->params[$name = substr($name, 0, $pos)] ??
            $this->match(strrpos($name, Arg::SEPARATOR), $name);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function name($name)
    {
        return (string) ($name ?: $this->name);
    }

    /**
     * @param string $query
     * @param string $fragment
     * @param array $options
     * @return array
     */
    protected function options($query, $fragment, array $options = [])
    {
        return [Arg::FRAGMENT => $fragment, Arg::QUERY => $query] + $options;
    }

    /**
     * @param $request
     * @param $parent
     * @return mixed
     */
    protected function parent($request, $parent)
    {
        $parent && ($name = $parent[Arg::NAME]) &&
            $this->params[$name] = $parent[Arg::PARAMS];

        return $request && $request !== $parent ? $this->parent($parent, $parent[Arg::PARENT]) : null;
    }

    /**
     * @param string $name
     * @param array $params
     * @return array
     */
    protected function params($name, array $params)
    {
        return $params + ($this->params[$name] ?? $this->match(strrpos($name, Arg::SEPARATOR), $name));
    }

    /**
     * @param array $route
     * @param array $options
     * @return Uri|null
     */
    protected function route(array $route, $options)
    {
        return $this->generate($this->name(array_shift($route)), $route, $options);
    }

    /**
     * @param null|Uri $uri
     * @return null|string
     */
    protected function uri($uri)
    {
        return $uri ? $this->assemble($this->absolute($uri)) : null;
    }

    /**
     * @param array|string $route
     * @param array|string $query
     * @param string $fragment
     * @param array $options
     * @return string
     */
    function __invoke($route = null, $query = '', $fragment = '', array $options = [])
    {
        return $this->create($route, $query, $fragment, $options) ?:
            $this->assemble($route, $query, $fragment, $this->absolute($options));
    }
}
