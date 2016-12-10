<?php
/**
 *
 */

namespace Mvc5\Response\Version;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Response;

trait Version
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    protected function version(Request $request, Response $response)
    {
        !$response->version() &&
            $response[Arg::VERSION] = $request->version();

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    function __invoke(Request $request, Response $response)
    {
        return $this->version($request, $response);
    }
}
