<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Template\Layout\Model;
use Mvc5\View\ViewLayout;

class Layout
{
    /**
     *
     */
    use Model;

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
     * @return Response
     */
    protected function response(Response $response)
    {
        return $response->with(Arg::BODY,  $this->layout($this->layout, $response->body()));
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return mixed|Response
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        return $next($request, $this->response($response));
    }
}
