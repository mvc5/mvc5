<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Plugin;

class Dispatch
{
    /**
     *
     */
    use Plugin;

    /**
     *
     */
    const WEB_RESPONSE = 'web\response';

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        return $next($request, $this->call(self::WEB_RESPONSE, [Arg::REQUEST => $request, Arg::RESPONSE => $response]));
    }
}
