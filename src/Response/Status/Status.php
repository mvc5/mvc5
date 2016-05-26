<?php
/**
 *
 */

namespace Mvc5\Response\Status;

use Mvc5\Arg;
use Mvc5\Http\Error;
use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Http\Status\ReasonPhrase;

trait Status
{
    /**
     *
     */
    use ReasonPhrase;

    /**
     * @param Error $error
     * @param Response $response
     * @return Response
     */
    protected function error(Error $error, Response $response)
    {
        $response[Arg::STATUS] = $error->status();
        $response[Arg::REASON] = $this->statusReasonPhrase($error->status());

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    protected function status(Request $request, Response $response)
    {
        if ($request[Arg::ERROR]) {
            return $this->error($request[Arg::ERROR], $response);
        }

        !$response->status() &&
            $response[Arg::STATUS] = Arg::HTTP_OK;

        !$response->reason() &&
            $response[Arg::REASON] = $this->statusReasonPhrase($response->status());

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    function __invoke(Request $request, Response $response)
    {
        return $this->status($request, $response);
    }
}
