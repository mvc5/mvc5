<?php
/**
 *
 */

namespace Mvc5\Url;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Uri;

use function array_shift;
use function strrpos;
use function substr;

class Plugin
{
    /**
     * @var bool|false
     */
    protected bool $absolute = false;

    /**
     * @var callable
     */
    protected $assembler;

    /**
     * @var callable
     */
    protected $generator;

    /**
     * @var string|null
     */
    protected ?string $name = null;

    /**
     * @var array
     */
    protected array $params = [];

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
        $this->assembler = $assembler ?? new Assemble;
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
     * @param array|string|null $query
     * @param string|null $fragment
     * @param array $options
     * @return string|null
     */
    protected function assemble($route, $query = null, string $fragment = null, array $options = []) : ?string
    {
        return $route ? ($this->assembler)($route, $query, $fragment, $options) : null;
    }

    /**
     * @param array|string|Uri|null $route
     * @param array|string|null $query
     * @param string|null $fragment
     * @param array $options
     * @return string|null
     */
    protected function create($route, $query = null, string $fragment = null, array $options = []) : ?string
    {
        return $route instanceof Uri ? $this->uri($route) :
            $this->uri($this->route((array) $route, $this->options($query, $fragment, $options)));
    }

    /**
     * @param string $name
     * @param array $params
     * @param array $options
     * @return Uri|null
     */
    protected function generate(string $name, array $params, array $options) : ?Uri
    {
        return $name[0] === Arg::SEPARATOR ? null : ($this->generator)($name, $this->params($name, $params), $options);
    }

    /**
     * @param int $pos
     * @param string $name
     * @return array
     */
    protected function match(int $pos, string $name) : array
    {
        return !$pos ? [] : $this->params[$name = substr($name, 0, $pos)] ??
            $this->match((int) strrpos($name, Arg::SEPARATOR), $name);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function name($name) : string
    {
        return (string) ($name ?? $this->name);
    }

    /**
     * @param array|string $query
     * @param string|null $fragment
     * @param array $options
     * @return array
     */
    protected function options($query, string $fragment = null, array $options = []) : array
    {
        return [Arg::FRAGMENT => $fragment, Arg::QUERY => $query] + $options;
    }

    /**
     * @param Request|null $request
     * @param Request|null $parent
     * @return Request|null
     */
    protected function parent(Request $request = null, Request $parent = null) : ?Request
    {
        $parent && ($name = $parent[Arg::NAME]) &&
            $this->params[$name] = $parent[Arg::PARAMS] ?? [];

        return $request && $request !== $parent ? $this->parent($parent, $parent[Arg::PARENT] ?? null) : null;
    }

    /**
     * @param string $name
     * @param array $params
     * @return array
     */
    protected function params(string $name, array $params) : array
    {
        return $params + ($this->params[$name] ?? $this->match((int) strrpos($name, Arg::SEPARATOR), $name));
    }

    /**
     * @param array $route
     * @param array $options
     * @return Uri|null
     */
    protected function route(array $route, array $options) : ?Uri
    {
        return $this->generate($this->name(array_shift($route)), $route, $options);
    }

    /**
     * @param array|Uri $uri
     * @return string|null
     */
    protected function uri($uri) : ?string
    {
        return $uri ? $this->assemble($this->absolute($uri)) : null;
    }

    /**
     * @param array|string|Uri|null $route
     * @param array|string|null $query
     * @param string|null $fragment
     * @param array $options
     * @return string|null
     */
    function __invoke($route = null, $query = null, string $fragment = null, array $options = []) : ?string
    {
        return $this->create($route, $query, $fragment, $options) ??
            $this->assemble($route, $query, $fragment, $this->absolute($options));
    }
}
