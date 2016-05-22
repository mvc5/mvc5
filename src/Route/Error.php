<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Arg;
use Mvc5\Plugin;
use Mvc5\Http\Request as Mvc5Request;
use Mvc5\Response\Error as ResponseError;
use Mvc5\Response\Error\NotFound;

class Error
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
     * @param Mvc5Request $request
     * @param ResponseError $error
     * @return Request
     */
    protected function error(Mvc5Request $request, ResponseError $error)
    {
        $request[Arg::CONTROLLER] = $this->controller;
        $request[Arg::ERROR]      = $error;
        $request[Arg::NAME]       = $this->name;

        return $request;
    }

    /**
     * @param Mvc5Request|Request $request
     * @param ResponseError|null $error
     * @return Request
     */
    function __invoke(Mvc5Request $request, ResponseError $error = null)
    {
        return $request->name() ? $request : $this->error($request, $error ?: new NotFound);
    }
}
