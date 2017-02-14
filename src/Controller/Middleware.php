<?php
/**
 *
 */

namespace Mvc5\Controller;

use Mvc5\Arg;
use Mvc5\Http\Response;
use Mvc5\Plugin;

class Middleware
{
    /**
     *
     */
    use Plugin;

    /**
     * @var
     */
    protected $controller;

    /**
     * @var array
     */
    protected $stack;

    /**
     * @param $controller
     * @param array $stack
     */
    function __construct($controller, array $stack = [])
    {
        $this->controller = $controller;
        $this->stack = $stack;
    }

    /**
     * @param $request
     * @param $response
     * @return array
     */
    protected function args($request, $response)
    {
        return [
            Arg::CONTROLLER => $this->controller,
            Arg::REQUEST    => $request,
            Arg::RESPONSE   => $response,
            Arg::NEXT       => $this->next()
        ];
    }

    /**
     * @return \Closure
     */
    protected function next()
    {
        return function($request, $response) {
            return ($next = next($this->stack)) ? $this->call($next, $this->args($request, $response)) : $response;
        };
    }

    /**
     * @param $request
     * @param $response
     * @return callable|mixed|null|object|Response
     */
    function __invoke($request, $response)
    {
        return $this->stack ? $this->call(reset($this->stack), $this->args($request, $response)) : $response;
    }
}
