<?php
/**
 *
 */

namespace Mvc5\Route\Exception;

use Mvc5\Arg;
use Mvc5\Route\Route;
use Throwable;

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
     * @param Route $route
     * @param Throwable $exception
     * @return Route
     */
    public function __invoke(Route $route, Throwable $exception)
    {
        $route[Arg::CONTROLLER] = $this->controller;
        $route[Arg::EXCEPTION]  = $exception;
        $route[Arg::NAME]       = $this->name;

        return $route;
    }
}
