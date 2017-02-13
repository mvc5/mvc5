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
    protected $args;

    /**
     * @var array
     */
    protected $stack;

    /**
     * @param array $stack
     * @param array $args
     */
    function __construct(array $stack = [], array $args = [])
    {
        $this->args = $args;
        $this->stack = $stack;
    }

    /**
     * @param $request
     * @param $response
     * @param $next
     * @return array
     */
    protected function args($request, $response, $next)
    {
        return $this->args + [Arg::REQUEST => $request, Arg::RESPONSE => $response, Arg::NEXT => $next];
    }

    /**
     * @param callable|null $pipe
     * @return \Closure
     */
    protected function next(callable $pipe = null)
    {
        return function(Http\Request $request, Http\Response $response) use ($pipe) {
            return ($next = next($this->stack)) ? $this->call($next, $this->args($request, $response, $this->next($pipe)))
                : ($pipe ? $pipe($request, $response) : $response);
        };
    }

    /**
     * @param Http\Request $request
     * @param Http\Response $response
     * @param callable|null $next
     * @return callable|mixed|null|object|Http\Response
     */
    function __invoke(Http\Request $request, Http\Response $response, callable $next = null)
    {
        return $this->stack ? $this->call(reset($this->stack), $this->args($request, $response, $this->next($next))) : (
            $next ? $next($request, $response) : $response
        );
    }
}
