<?php
/**
 *
 */

namespace Mvc5\Request\Error;

use Mvc5\Arg;
use Mvc5\Plugin;
use Mvc5\Http\Error as HttpError;
use Mvc5\Http\Error\NotFound;
use Mvc5\Request\Request;

trait Error
{
    /**
     * @var
     */
    protected $controller;

    /**
     * @var
     */
    protected $name;

    /**
     * @param $name
     * @param $controller
     */
    function __construct($name, $controller)
    {
        $this->controller = $controller;
        $this->name       = $name;
    }

    /**
     * @param Request $request
     * @param HttpError $error
     * @return Request
     */
    protected function error(Request $request, HttpError $error)
    {
        $request[Arg::CONTROLLER] = $this->controller;
        $request[Arg::ERROR]      = $error;
        $request[Arg::NAME]       = $this->name;

        return $request;
    }

    /**
     * @param Request $request
     * @param HttpError|null $error
     * @return Request
     */
    protected function request(Request $request, HttpError $error = null)
    {
        return $request->name() ? $request : $this->error($request, $error ?: new NotFound);
    }

    /**
     * @param Request $request
     * @param HttpError|null $error
     * @return Request
     */
    function __invoke(Request $request, HttpError $error = null)
    {
        return $this->request($request, $error);
    }
}
