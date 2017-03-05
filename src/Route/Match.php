<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Http\Request;
use Mvc5\Plugin;

class Match
{
    /**
     *
     */
    use Plugin;

    /**
     * @var array
     */
    protected $stack;

    /**
     * @param array $stack
     */
    function __construct(array $stack = [])
    {
        $this->stack = $stack;
    }

    /**
     * @return \Closure
     */
    protected function next()
    {
        return function($route, $request) {
            return ($next = next($this->stack)) ? $this->call($next, [$route, $request, $this->next()]) : $request;
        };
    }

    /**
     * @param Route $route
     * @param Request $request
     * @return Request;

     */
    function __invoke($route, $request)
    {
        return $this->stack ? $this->call(reset($this->stack), [$route, $request, $this->next()]) : $request;
    }
}
