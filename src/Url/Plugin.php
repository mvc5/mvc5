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
     * @param callable|null $assembler
     * @param bool|false $absolute
     */
    function __construct(Request $request, callable $generator, callable $assembler = null, bool $absolute = false)
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
     * @param array|Uri $uri
     * @param array $options
     * @return array|Uri
     */
    protected function absolute($uri, array $options = [])
    {
        if (!$this->absolute && empty($uri[Arg::ABSOLUTE])) {
            return $uri;
        }

        !isset($uri[Arg::SCHEME]) &&
            $options[Arg::SCHEME] = $this->uri[Arg::SCHEME];

        !isset($uri[Arg::PORT]) &&
            $options[Arg::PORT] = $this->uri[Arg::PORT];

        !isset($uri[Arg::HOST]) &&
            $options[Arg::HOST] = $this->uri[Arg::HOST];

        return !$options ? $uri : ($uri instanceof Uri ? $uri->with($options) : $options + $uri);
    }

    /**
     * @param string|Uri $route
     * @param array|null|string $query
     * @param null|string $fragment
     * @param array $options
     * @return mixed
     */
    protected function assemble($route, $query = null, string $fragment = null, array $options = [])
    {
        return $route ? ($this->assembler)($route, $query, $fragment, $options) : null;
    }

    /**
     * @param null|string|string[]|Uri $route
     * @param array|null|string $query
     * @param null|string $fragment
     * @param array $options
     * @return null|string
     */
    protected function create($route, $query = null, string $fragment = null, array $options = [])
    {
        return $route instanceof Uri ? $this->uri($route) :
            $this->uri($this->route((array) $route, $this->options($query, $fragment, $options)));
    }

    /**
     * @param string $name
     * @param array $params
     * @param array $options
     * @return null|Uri
     */
    protected function generate(string $name, array $params, array $options)
    {
        return $name[0] === Arg::SEPARATOR ? null : ($this->generator)($name, $this->params($name, $params), $options);
    }

    /**
     * @param int $pos
     * @param string $name
     * @return array
     */
    protected function match(int $pos, string $name)
    {
        return !$pos ? [] : $this->params[$name = substr($name, 0, $pos)] ??
            $this->match((int) strrpos($name, Arg::SEPARATOR), $name);
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
     * @param array|string $query
     * @param null|string $fragment
     * @param array $options
     * @return array
     */
    protected function options($query, string $fragment = null, array $options = [])
    {
        return [Arg::FRAGMENT => $fragment, Arg::QUERY => $query] + $options;
    }

    /**
     * @param null|Request $request
     * @param null|Request $parent
     * @return mixed
     */
    protected function parent(Request $request = null, Request $parent = null)
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
    protected function params(string $name, array $params)
    {
        return $params + ($this->params[$name] ?? $this->match((int) strrpos($name, Arg::SEPARATOR), $name));
    }

    /**
     * @param string[] $route
     * @param array $options
     * @return Uri|null
     */
    protected function route(array $route, array $options)
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
     * @param null|string|string[]|Uri $route
     * @param array|null|string $query
     * @param null|string $fragment
     * @param array $options
     * @return string
     */
    function __invoke($route = null, $query = null, string $fragment = null, array $options = [])
    {
        return $this->create($route, $query, $fragment, $options) ?:
            $this->assemble($route, $query, $fragment, $this->absolute($options));
    }
}
