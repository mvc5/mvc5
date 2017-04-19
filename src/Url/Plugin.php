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
     * @param Request $request
     * @param callable $generator
     * @param callable $assembler
     */
    function __construct(Request $request, callable $generator, callable $assembler = null)
    {
        $this->assembler = $assembler ?: new Assemble;
        $this->generator = $generator;

        $this->name = $request[Arg::NAME];

        $this->params[$this->name] = (array) $request[Arg::PARAMS];

        $parent = $request[Arg::PARENT];

        while($parent && $name = $parent[Arg::NAME]) {
            $this->params[$name] = $parent[Arg::PARAMS];
            $parent = $parent[Arg::PARENT];
        }
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
     * @param array|string $route
     * @param array|string $query
     * @param string $fragment
     * @param array $options
     * @return Uri
     */
    protected function create($route, $query, $fragment, $options)
    {
        return $this->assemble($this->route((array) $route, $this->options($query, $fragment, $options))) ?:
            $this->assemble($route, $query, $fragment, $options);
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
     * @param array|string $route
     * @param array|string $query
     * @param string $fragment
     * @param array $options
     * @return string
     */
    function __invoke($route = null, $query = '', $fragment = '', array $options = [])
    {
        return $route instanceof Uri ? $this->assemble($route) : $this->create($route, $query, $fragment, $options);
    }
}
