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
    protected $stack;

    /**
     * @param Service $service
     * @param array|\Iterator $stack
     */
    function __construct(Service $service, $stack = [])
    {
        $this->service = $service;
        $this->stack = $stack;
    }

    /**
     * @param array $args
     * @return array
     */
    protected function args(array $args)
    {
        $args[] = $this->callable();
        return $args;
    }

    /**
     * @param $middleware
     * @param array $args
     * @return mixed
     */
    protected function call($middleware, $args)
    {
        return $this->service->call($middleware, $this->args($args));
    }

    /**
     * @return \Closure
     */
    protected function callable()
    {
        return function(...$args) {
            return ($middleware = $this->next()) ? $this->call($middleware, $args) : $this->end($args);
        };
    }

    /**
     * @param array $args
     * @return mixed|null
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
        if (is_array($this->stack)) {
            return next($this->stack);
        }

        $this->stack->next();

        return $this->stack->current();
    }

    /**
     * @return mixed
     */
    protected function rewind()
    {
        if (is_array($this->stack)) {
            return reset($this->stack);
        }

        $this->stack->rewind();

        return $this->stack->current();
    }

    /**
     * @param array ...$args
     * @return mixed
     */
    function __invoke(...$args)
    {
        return $this->stack ? $this->call($this->rewind(), $args) : $this->end($args);
    }
}
