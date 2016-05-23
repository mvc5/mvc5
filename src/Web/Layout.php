<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Model\ViewLayout;
use Mvc5\View\Layout\Model as LayoutModel;

class Layout
{
    /**
     *
     */
    use LayoutModel;

    /**
     * @var ViewLayout
     */
    protected $layout;

    /**
     * @param ViewLayout $layout
     */
    function __construct(ViewLayout $layout)
    {
        $this->layout = $layout;
    }

    /**
     * @param Response $response
     * @param $body
     * @return Response
     */
    protected function response(Response $response, $body)
    {
        if ($body) {
            $response[Arg::BODY] = $body;
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
        return $next($request, $this->response($response, $this->model($this->layout, $response[Arg::BODY])));
    }
}
