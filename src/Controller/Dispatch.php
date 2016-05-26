<?php
/**
 *
 */

namespace Mvc5\Controller;

use Mvc5\Arg;
use Mvc5\Http\Request as HttpRequest;
use Mvc5\Http\Response as HttpResponse;
use Mvc5\Plugin;

class Dispatch
{
    /**
     *
     */
    use Plugin;

    /**
     * @param HttpRequest $request
     * @param HttpResponse $response
     * @return mixed|Response
     */
    function __invoke(HttpRequest $request, HttpResponse $response)
    {
        return $this->trigger([Arg::CONTROLLER_RESPONSE, Arg::REQUEST => $request, Arg::RESPONSE => $response]);
    }
}
