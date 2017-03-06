<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Plugins\Service as _Service;
use Mvc5\Service\Context as _Context;

class Context
{
    /**
     *
     */
    use _Service;

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return mixed|Response
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        _Context::bind($this->service());

        return $next($request, $response);
    }
}
