<?php
/**
 *
 */

namespace Mvc5\Request\Error;

use Mvc5\Http\Error;
use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Plugins\Service;

use const Mvc5\{ ACCEPTS_JSON, ERROR, ERROR_MODEL, RESPONSE_JSON_ERROR };

class Controller
{
    /**
     *
     */
    use Service;

    /**
     * @param Error $error
     * @return Response
     */
    protected function json(Error $error) : Response
    {
        return $this->plugin(RESPONSE_JSON_ERROR, [ERROR => $error]);
    }

    /**
     * @param Error $error
     * @return ViewModel
     */
    protected function model(Error $error) : ViewModel
    {
        return $this->plugin(ERROR_MODEL, [ERROR => $error]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    function __invoke(Request $request)
    {
        return $request[ACCEPTS_JSON] ? $this->json($request[ERROR]) : $this->model($request[ERROR]);
    }
}
