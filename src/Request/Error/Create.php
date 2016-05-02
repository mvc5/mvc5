<?php
/**
 *
 */

namespace Mvc5\Request\Error;

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
     * @param $error
     * @return array|\ArrayAccess
     */
    function __invoke($request, $error)
    {
        $request[Arg::CONTROLLER] = $this->controller;
        $request[Arg::ERROR]      = $error;
        $request[Arg::NAME]       = $this->name;

        return $request;
    }
}
