<?php
/**
 *
 */

namespace Mvc5\Request\Exception;

use Mvc5\Arg;

class Create
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
     * @param array|\ArrayAccess $request
     * @param $exception
     * @return array|\ArrayAccess
     */
    function __invoke($request, $exception)
    {
        $request[Arg::CONTROLLER] = $this->controller;
        $request[Arg::EXCEPTION]  = $exception;
        $request[Arg::NAME]       = $this->name;

        return $request;
    }
}
