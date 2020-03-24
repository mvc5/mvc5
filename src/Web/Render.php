<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Template\TemplateModel;
use Mvc5\View\View;

use const Mvc5\BODY;

class Render
{
    /**
     * @var View
     */
    protected View $view;

    /**
     * @param View $view
     */
    function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * @param Response $response
     * @return Response
     */
    protected function response(Response $response) : Response
    {
        return $response->body() instanceof TemplateModel ?
            $response->with(BODY, $this->view->render($response->body())) : $response;
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
