<?php
/**
 *
 */

namespace Mvc5\Response\Prepare;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Http\Response\StatusCode;

trait Prepare
{
    /**
     *
     */
    use StatusCode;

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    protected function prepare(Request $request, Response $response)
    {
        !$response->status() &&
            $response[Arg::STATUS] = Arg::HTTP_OK;

        !$response->reason() &&
            $response[Arg::REASON] = $this->statusCodeText($response->status());

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
        return $this->prepare($request, $response);
    }
}