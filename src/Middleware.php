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
     * @return \Closure
     */
    protected function next()
    {
        return function(Http\Request $request, Http\Response $response) {
            return ($next = next($this->stack)) ? $this->call($next, [$request, $response, $this->next()]) : $response;
        };
    }

    /**
     * @param Http\Request $request
     * @param Http\Response $response
     * @return callable|mixed|null|object|Http\Response
     */
    function __invoke(Http\Request $request, Http\Response $response)
    {
        return $this->call(
            current($this->stack) ?: new Exception('Empty call stack'), [$request, $response, $this->next()]
        );
    }
}
