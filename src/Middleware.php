<?php
/**
 *
 */

namespace Mvc5;

class Middleware
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
     * @param $request
     * @param $response
     * @return array
     */
    protected function args($request, $response)
    {
        return [Arg::REQUEST => $request, Arg::RESPONSE => $response, Arg::NEXT => $this->next()];
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
     * @param Http\Request $request
     * @param Http\Response $response
     * @return callable|mixed|null|object|Http\Response
     */
    function __invoke($request, $response)
    {
        return $this->stack ? $this->call(reset($this->stack), $this->args($request, $response)) : $response;
    }
}
