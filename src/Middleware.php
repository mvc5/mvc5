<?php
/**
 *
 */

namespace Mvc5;

class Middleware
{
    /**
     * @var Service\Service
     */
    protected $service;

    /**
     * @var array
     */
    protected $stack;

    /**
     * @param Service\Service $service
     * @param array $stack
     */
    function __construct(Service\Service $service, array $stack = [])
    {
        $this->service = $service;
        $this->stack = $stack;
    }

    /**
     * @param $middleware
     * @param Http\Request $request
     * @param Http\Response $response
     * @return mixed
     */
    protected function call($middleware, $request, $response)
    {
        return $this->service->call($middleware, [$request, $response, $this->next()]);
    }

    /**
     * @return \Closure
     */
    protected function next()
    {
        return function($request, $response) {
            return ($middleware = next($this->stack)) ? $this->call($middleware, $request, $response) : $response;
        };
    }

    /**
     * @param Http\Request $request
     * @param Http\Response $response
     * @return callable|mixed|null|object|Http\Response
     */
    function __invoke($request, $response)
    {
        return $this->stack ? $this->call(reset($this->stack), $request, $response) : $response;
    }
}
