<?php
/**
 *
 */

namespace Mvc5\Response;

use Mvc5\Arg;
use Mvc5\Http\Request as HttpRequest;
use Mvc5\Http\Response as HttpResponse;

class Version
{
    /**
     * @param HttpRequest $request
     * @param HttpResponse $response
     * @return HttpRequest
     */
    function __invoke(HttpRequest $request, HttpResponse $response)
    {
        !$response->version() &&
            $response[Arg::VERSION] = $request->version();

        return $response;
    }
}
