<?php
/**
 *
 */

namespace Mvc5\Web;

use ArrayAccess;
use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Response;

final class Service
{
    /**
     * @var ArrayAccess
     */
    protected ArrayAccess $container;

    /**
     * @param ArrayAccess $container
     */
    function __construct(ArrayAccess $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function share(Request $request) : Request
    {
        return $this->container[Arg::REQUEST] = $request;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response|mixed
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        return $next($this->share($request), $response);
    }
}
