<?php
/**
 *
 */

namespace Mvc5\Url;

use Mvc5\Arg;
use Mvc5\Http\Uri;

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
     * @param string $name
     * @param array $params
     * @param array $options
     * @return Uri
     */
    protected function generate($name, array $params = [], array $options = [])
    {
        return ($this->generator)($name, $params, $options);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function name($name = null)
    {
        return $name ?? $this->name;
    }

    /**
     * @param string $query
     * @param string $fragment
     * @return array
     */
    protected function options($query = '', $fragment = '')
    {
        return [Arg::FRAGMENT => $fragment, Arg::QUERY => $query];
    }

    /**
     * @param string $name
     * @param array $params
     * @return array
     */
    protected function params($name, array $params = [])
    {
        return $name ? $params : $params + $this->params;
    }

    /**
     * @param Uri $uri
     * @return string
     */
    protected function url(Uri $uri)
    {
        return ($this->assembler)($uri);
    }

    /**
     * @param null $name
     * @param array $params
     * @param array|string $query
     * @param string $fragment
     * @return string
     */
    function __invoke($name = null, array $params = [], $query = '', $fragment = '')
    {
        return $this->url(
            $this->generate($this->name($name), $this->params($name, $params), $this->options($query, $fragment))
        );
    }
}
