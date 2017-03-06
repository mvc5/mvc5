<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Response\Send\Send as _Send;

class Send
{
    /**
     *
     */
    use _Send;

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return mixed|Response
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        return $next($request, $this->send($response));
    }
}
