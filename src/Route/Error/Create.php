<?php
/**
 *
 */

namespace Mvc5\Route\Error;

use Mvc5\Arg;
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
    public function __construct($name, $controller)
    {
        $this->controller = $controller;
        $this->name       = $name;
    }

    /**
     * @param array|\ArrayAccess|Route $route
     * @return array|\ArrayAccess|Route
     */
    public function __invoke($route)
    {
        $route[Arg::CONTROLLER] = $this->controller;
        $route[Arg::NAME]       = $this->name;

        return $route;
    }
}
