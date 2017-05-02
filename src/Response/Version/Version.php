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
        return $response->version() ? $response : $response->with(Arg::VERSION, $request->version());
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
