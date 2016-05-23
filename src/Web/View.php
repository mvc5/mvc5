<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Model\Template;
use Mvc5\Plugin;
use Mvc5\View\Template\Render;

class View
{
    /**
     *
     */
    use Render;

    /**
     * @param Response $response
     * @return Response
     */
    protected function response(Response $response)
    {
        if ($response[Arg::BODY] instanceof Template) {
            $response[Arg::BODY] = $this->render($response[Arg::BODY]);
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        return $next($request, $this->response($response));
    }
}
