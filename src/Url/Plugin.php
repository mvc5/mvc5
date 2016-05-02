<?php
/**
 *
 */

namespace Mvc5\Url;

use Mvc5\Arg;
use Mvc5\Request\Request;
use Mvc5\Signal;

class Plugin
{
    /**
     *
     */
    use Signal;

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
     * @param null|string $name
     * @param array $args
     * @return array
     */
    protected function args($name = null, array $args = [])
    {
        return $name ? $args : $args + $this->request->args();
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
        return $name ?? $this->request->name();
    }

    /**
     * @param array $options
     * @return array
     */
    protected function options(array $options = [])
    {
        return $options + [
            Arg::HOST   => $this->request->host(),
            Arg::PORT   => $this->request->port(),
            Arg::SCHEME => $this->request->scheme()
        ];
    }

    /**
     * @param string $name
     * @param array $args
     * @param array $options
     * @return string
     */
    protected function url($name, array $args = [], array $options = [])
    {
        return $this->signal($this->generator(), [$name, $args, $options]);
    }

    /**
     * @param null $name
     * @param array $args
     * @param array $options
     * @return string
     */
    function __invoke($name = null, array $args = [], array $options = [])
    {
        return $this->url($this->name($name), $this->args($name, $args), $this->options($options));
    }
}
