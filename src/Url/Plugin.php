<?php
/**
 *
 */

namespace Mvc5\Url;

use Mvc5\Arg;
use Mvc5\Http\Request;

class Plugin
{
    /**
     * @var callable
     */
    protected $generator;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Request $request
     * @param callable $generator
     */
    function __construct(Request $request, callable $generator)
    {
        $this->generator = $generator;
        $this->request   = $request;
    }

    /**
     * @return callable
     */
    protected function generator()
    {
        return $this->generator;
    }

    /**
     * @param null|string $name
     * @return string
     */
    protected function name($name = null)
    {
        return $name ?? $this->request[Arg::NAME];
    }

    /**
     * @param array $options
     * @return array
     */
    protected function options(array $options = [])
    {
        return $options + [
            Arg::HOST   => $this->request[Arg::HOST],
            Arg::PORT   => $this->request[Arg::PORT],
            Arg::SCHEME => $this->request[Arg::SCHEME]
        ];
    }

    /**
     * @param $name
     * @param array $params
     * @return array
     */
    protected function params($name, array $params = [])
    {
        return $name ? $params : $params + (array) $this->request[Arg::PARAMS];
    }

    /**
     * @param string $name
     * @param array $params
     * @param array $options
     * @return string
     */
    protected function url($name, array $params = [], array $options = [])
    {
        return ($this->generator())($name, $params, $options);
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
