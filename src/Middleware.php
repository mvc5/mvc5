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
    public function __construct(array $stack = [])
    {
        $this->stack = $stack;
    }

    /**
     * @return \Closure
     */
    protected function next()
    {
        return function(Request\Request $request, Response\Response $response) {
            return ($next = next($this->stack)) ? $this->call($next, [$request, $response, $this->next()]) : $response;
        };
    }

    /**
     * @param Request\Request $request
     * @param Response\Response $response
     * @return callable|mixed|null|object|Response\Response
     */
    public function __invoke(Request\Request $request, Response\Response $response)
    {
        return $this->call(
            current($this->stack) ?: new Exception('Empty call stack'), [$request, $response, $this->next()]
        );
    }
}
