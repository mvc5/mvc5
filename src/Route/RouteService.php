<?php
/**
 *
 */

namespace Mvc5\Route;

trait RouteService
{
    /**
     * @var Route
     */
    protected $route;

    /**
     * @return null|Route
     */
    public function route()
    {
        return $this->route;
    }

    /**
     * @param Route $route
     * @return void
     */
    public function setRoute(Route $route)
    {
        $this->route = $route;
    }
}
