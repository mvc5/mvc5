<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Http\Request;
use Mvc5\Service\Service;

class Match
{
    /**
     * @var Service
     */
    protected $service;

    /**
     * @var array
     */
    protected $stack;

    /**
     * @param Service $service
     * @param array $stack
     */
    function __construct(Service $service, array $stack = [])
    {
        $this->service = $service;
        $this->stack = $stack;
    }

    /**
     * @param $match
     * @param Route $route
     * @param Request $request
     * @return mixed
     */
    protected function call($match, $route, $request)
    {
        return $this->service->call($match, [$route, $request, $this->next()]);
    }

    /**
     * @return \Closure
     */
    protected function next()
    {
        return function($route, $request) {
            return ($match = next($this->stack)) ? $this->call($match, $route, $request) : $request;
        };
    }

    /**
     * @param Route $route
     * @param Request $request
     * @return Request;

     */
    function __invoke($route, $request)
    {
        return $this->stack ? $this->call(reset($this->stack), $route, $request) : $request;
    }
}
