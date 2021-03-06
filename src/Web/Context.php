<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Plugins\Service;
use Mvc5\Service\Context as ServiceContext;

final class Context
{
    /**
     *
     */
    use Service;

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response|mixed
     * @throws \Throwable
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        ServiceContext::bind($this->service);

        return $next($request, $response);
    }
}
