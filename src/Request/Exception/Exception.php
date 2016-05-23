<?php
/**
 *
 */

namespace Mvc5\Request\Exception;

use Mvc5\Arg;
use Mvc5\Http\Error\ServerError;
use Mvc5\Http\Request;

trait Exception
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
     * @param \Exception $exception
     * @return Request
     */
    protected function exception(Request $request, \Exception $exception)
    {
        $request[Arg::CONTROLLER] = $this->controller;
        $request[Arg::EXCEPTION]  = $exception;
        $request[Arg::NAME]       = $this->name;
        $request[Arg::ERROR]      = new ServerError;

        return $request;
    }

    /**
     * @param Request $request
     * @param \Exception $exception
     * @return Request
     */
    function __invoke(Request $request, \Exception $exception)
    {
        return $this->exception($request, $exception);
    }
}
