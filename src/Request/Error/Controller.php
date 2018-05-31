<?php
/**
 *
 */

namespace Mvc5\Request\Error;

use Mvc5\Arg;
use Mvc5\Http\Error;
use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Plugins\Service;

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
        return $this->plugin(Arg::RESPONSE_JSON_ERROR, [Arg::ERROR => $error]);
    }

    /**
     * @param Error $error
     * @return ViewModel
     */
    protected function model(Error $error) : ViewModel
    {
        return $this->plugin(Arg::ERROR_MODEL, [Arg::ERROR => $error]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    function __invoke(Request $request)
    {
        return $request[Arg::ACCEPTS_JSON] ? $this->json($request[Arg::ERROR]) : $this->model($request[Arg::ERROR]);
    }
}
