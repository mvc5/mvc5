<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Http\Request;
use Mvc5\Http\Response;

use const Mvc5\BODY;

final class Layout
{
    /**
     *
     */
    use \Mvc5\Template\Layout\Layout;

    /**
     * @param Response $response
     * @return Response
     */
    protected function response(Response $response) : Response
    {
        return $response->with(BODY,  $this->layout($this->layout, $response->body()));
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response|mixed
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        return $next($request, $this->response($response));
    }
}
