<?php
/**
 *
 */

namespace Mvc5\Url;

use Mvc5\Arg;
use Mvc5\Http\Uri;
use Mvc5\Http\Uri\Config as HttpUri;

class Plugin
{
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
    protected $params;

    /**
     * @param array|\ArrayAccess $request
     * @param callable $generator
     * @param callable $assembler
     */
    function __construct($request, callable $generator, callable $assembler = null)
    {
        $this->assembler = $assembler ?: new Assemble;
        $this->generator = $generator;
        $this->name      = $request[Arg::NAME];
        $this->params    = (array) $request[Arg::PARAMS];
    }

    /**
     * @param Uri $uri
     * @return string
     */
    protected function assemble($uri)
    {
        return ($this->assembler)($uri);
    }

    /**
     * @param array $route
     * @param array $options
     * @return Uri
     */
    protected function create(array $route, array $options)
    {
        return $this->url(array_shift($route), $this->values($route), $options);
    }

    /**
     * @param string $name
     * @param array $params
     * @param array $options
     * @return Uri
     */
    protected function generate($name, $params, $options)
    {
        return ($this->generator)($name, $params, $options);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function name($name)
    {
        return $name ?? $this->name;
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
        return $name ? $params : $params + $this->params;
    }

    /**
     * @param $path
     * @param array $options
     * @return HttpUri
     */
    protected function uri($path, array $options)
    {
        return new HttpUri([Arg::PATH => $path] + $options);
    }

    /**
     * @param string $name
     * @param array $params
     * @param array $options
     * @return Uri
     */
    protected function url($name, $params, $options)
    {
        return $this->generate($this->name($name), $this->params($name, $params), $options) ?: $this->uri($name, $options);
    }

    /**
     * @param array $params
     * @return array
     */
    protected function values(array $params)
    {
        return is_numeric(key($params)) ? $params[0] : $params;
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
        return $this->assemble(
            $route instanceof Uri ? $route : $this->create((array) $route, $this->options($query, $fragment, $options))
        );
    }
}
