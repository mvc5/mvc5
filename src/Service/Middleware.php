<?php
/**
 *
 */

namespace Mvc5\Service;

use Closure;
use Iterator;
use Mvc5\Iterator as Mvc5Iterator;

use function end;

trait Middleware
{
    /**
     * @var Service
     */
    protected Service $service;

    /**
     * @var Iterator
     */
    protected Iterator $middleware;

    /**
     * @param Service $service
     * @param array|Iterator $middleware
     */
    function __construct(Service $service, $middleware = [])
    {
        $this->service = $service;
        $this->middleware = is_array($middleware) ? new Mvc5Iterator($middleware) : $middleware;
    }

    /**
     * @param callable|mixed $current
     * @param array $args
     * @return mixed
     */
    protected function call($current, array $args = [])
    {
        return $current ? $this->service->call($current, [...$args, $this->delegate()]) : ($args ? end($args) : null);
    }

    /**
     * @return Closure
     */
    protected function delegate() : Closure
    {
        return fn(...$args) => $this->call($this->next(), $args);
    }

    /**
     * @return mixed
     */
    protected function next()
    {
        $this->middleware->next();
        return $this->middleware->current();
    }

    /**
     * @return mixed
     */
    protected function rewind()
    {
        $this->middleware->rewind();
        return $this->middleware->current();
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
