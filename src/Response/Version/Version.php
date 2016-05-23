<?php
/**
 *
 */

namespace Mvc5\Response\Version;

use Mvc5\Arg;
use Mvc5\Http\Request as HttpRequest;
use Mvc5\Http\Response as HttpResponse;

trait Version
{
    /**
     * @param HttpRequest $request
     * @param HttpResponse $response
     * @return HttpRequest
     */
    protected function version(HttpRequest $request, HttpResponse $response)
    {
        !$response->version() &&
            $response[Arg::VERSION] = $request->version();

        return $response;
    }

    /**
     * @param HttpRequest $request
     * @param HttpResponse $response
     * @return HttpRequest
     */
    function __invoke(HttpRequest $request, HttpResponse $response)
    {
        return $this->version($request, $response);
    }
}
