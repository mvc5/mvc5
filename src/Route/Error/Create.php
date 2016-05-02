<?php
/**
 *
 */

namespace Mvc5\Route\Error;

use Mvc5\Arg;
use Mvc5\Response\Error;
use Mvc5\Route\Route;

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
     * @param Route $route
     * @param Error $error
     * @return Route
     */
    function __invoke(Route $route, Error $error)
    {
        $route[Arg::CONTROLLER] = $this->controller;
        $route[Arg::ERROR]      = $error;
        $route[Arg::NAME]       = $this->name;

        return $route;
    }
}
