<?php
/**
 *
 */

namespace Mvc5\Request\Error;

use Mvc5\Arg;
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
    function request(Request $request)
    {
        return !$request[Arg::ERROR] ? $request :
            $request->with([Arg::CONTROLLER => $this->controller, Arg::NAME => $this->name]);
    }

    /**
     * @param Request $request
     * @return Request
     */
    function __invoke(Request $request)
    {
        return !$request[Arg::ERROR] ? $request :
            $request->with([Arg::CONTROLLER => $this->controller, Arg::NAME => $this->name]);
    }
}
