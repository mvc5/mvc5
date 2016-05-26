<?php
/**
 *
 */

namespace Mvc5\Request\Error;

use Mvc5\Arg;
use Mvc5\Plugin;
use Mvc5\Http\Error as HttpError;
use Mvc5\Http\Request;

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
     * @return Request
     */
    protected function error(Request $request)
    {
        $request[Arg::CONTROLLER] = $this->controller;
        $request[Arg::NAME]       = $this->name;

        return $request;
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function request(Request $request)
    {
        return !$request[Arg::ERROR] ? $request : $this->error($request);
    }

    /**
     * @param Request $request
     * @return Request
     */
    function __invoke(Request $request)
    {
        return $this->request($request);
    }
}
