<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Plugin;

class Version
{
    /**
     *
     */
    use Plugin;

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        return $next(
            $request, $this->call(Arg::RESPONSE_VERSION, [Arg::REQUEST => $request, Arg::RESPONSE => $response])
        );
    }
}
