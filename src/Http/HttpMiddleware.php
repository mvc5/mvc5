<?php
/**
 *
 */

namespace Mvc5\Http;

use Mvc5\Service\Service;

class HttpMiddleware
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
     * @param $middleware
     * @param Request $request
     * @param Response $response
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
        return function(Request $request, Response $response) {
            return ($middleware = next($this->stack)) ? $this->call($middleware, $request, $response) : $response;
        };
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed|Response
     */
    function __invoke(Request $request, Response $response)
    {
        return $this->stack ? $this->call(reset($this->stack), $request, $response) : $response;
    }
}
