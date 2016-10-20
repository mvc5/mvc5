<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Model\Template;
use Mvc5\View\Template\View;

class Render
{
    /**
     * @param View
     */
    protected $renderer;

    /**
     * @param View $renderer
     */
    function __construct(View $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param $body
     * @return string
     */
    protected function render($body)
    {
        return $this->renderer->render($body);
    }

    /**
     * @param Response $response
     * @return Response
     */
    protected function response(Response $response)
    {
        $response->body() instanceof Template
            && $response[Arg::BODY] = $this->render($response->body());

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
