<?php
/**
 *
 */

namespace Mvc5\Controller;

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
     * @param Request $request
     * @param Response $response
     * @return mixed|Response
     */
    function __invoke(Request $request, Response $response)
    {
        return $this->trigger([Arg::CONTROLLER_RESPONSE, Arg::REQUEST => $request, Arg::RESPONSE => $response]);
    }
}
