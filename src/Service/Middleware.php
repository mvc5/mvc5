<?php
/**
 *
 */

namespace Mvc5\Service;

trait Middleware
{
    /**
     * @var Service
     */
    protected $service;

    /**
     * @var array|\Iterator
     */
    protected $config;

    /**
     * @param Service $service
     * @param array|\Iterator $config
     */
    function __construct(Service $service, $config = [])
    {
        $this->service = $service;
        $this->config = $config;
    }

    /**
     * @param $middleware
     * @param array $args
     * @return mixed
     */
    protected function call($middleware, array $args = [])
    {
        return $middleware ? $this->service->call($middleware, array_merge($args, [$this->delegate()])) : $this->end($args);
    }

    /**
     * @return \Closure
     */
    protected function delegate() : \Closure
    {
        return function(...$args) {
            return $this->call($this->next(), $args);
        };
    }

    /**
     * @param array $args
     * @return mixed
     */
    protected function end(array $args)
    {
        return $args ? end($args) : null;
    }

    /**
     * @return mixed
     */
    protected function next()
    {
        if ($this->config instanceof \Iterator) {
            $this->config->next();
            return $this->config->current();
        }

        return next($this->config);
    }

    /**
     * @return mixed
     */
    protected function rewind()
    {
        if ($this->config instanceof \Iterator) {
            $this->config->rewind();
            return $this->config->current();
        }

        return reset($this->config);
    }

    /**
     * @param array ...$args
     * @return mixed
     */
    function __invoke(...$args)
    {
        return $this->call($this->rewind(), $args);
    }
}
