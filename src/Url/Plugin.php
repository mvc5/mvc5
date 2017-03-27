<?php
/**
 *
 */

namespace Mvc5\Url;

use Mvc5\Arg;

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
    protected $options;

    /**
     * @var array
     */
    protected $params;

    /**
     * @param array|\ArrayAccess $request
     * @param callable $generator
     */
    function __construct($request, callable $generator)
    {
        $this->generator = $generator;
        $this->name      = $request[Arg::NAME];
        $this->params    = (array) $request[Arg::PARAMS];

        $uri = $request[Arg::URI];

        $this->options = array_filter([
            Arg::HOST   => $uri[Arg::HOST] ?? '',
            Arg::PORT   => $uri[Arg::PORT] ?? '',
            Arg::SCHEME => $uri[Arg::SCHEME] ?? ''
        ]);
    }

    /**
     * @param null|string $name
     * @return string
     */
    protected function name($name = null)
    {
        return $name ?? $this->name;
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
     * @param $name
     * @param array $params
     * @return array
     */
    protected function params($name, array $params = [])
    {
        return $name ? $params : $params + $this->params;
    }

    /**
     * @param string $name
     * @param array $params
     * @param array $options
     * @return string
     */
    protected function url($name, array $params = [], array $options = [])
    {
        return ($this->generator)($name, $params, $options);
    }

    /**
     * @param null $name
     * @param array $params
     * @param array $options
     * @return string
     */
    function __invoke($name = null, array $params = [], array $options = [])
    {
        return $this->url($this->name($name), $this->params($name, $params), $this->options($options));
    }
}
