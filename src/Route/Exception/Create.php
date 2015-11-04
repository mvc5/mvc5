<?php
/**
 *
 */

namespace Mvc5\Route\Exception;

use Mvc5\Route\Route;
use Throwable;

class Create
    implements CreateException
{
    /**
     * @var RouteException
     */
    protected $route;

    /**
     * @param RouteException $route
     */
    public function __construct(RouteException $route)
    {
        $this->route = $route;
    }

    /**
     * @param Route $route
     * @param Throwable $exception
     * @return RouteException
     */
    public function __invoke(Route $route, Throwable $exception)
    {
        $this->route->set(RouteException::EXCEPTION, $exception);
        $this->route->set(RouteException::ROUTE, $route);

        return $this->route;
    }
}
