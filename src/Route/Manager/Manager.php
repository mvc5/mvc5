<?php
/**
 *
 */

namespace Mvc5\Route\Manager;

use Mvc5\Event\Manager\EventManager;
use Mvc5\Event\Manager\Events;
use Mvc5\Route\Definition\Definition;
use Mvc5\Route\Exception\RouteException;
use Mvc5\Route\Router\RouteDispatch;
use Mvc5\Route\Match\RouteMatch;
use Mvc5\Route\Route;
use Mvc5\Service\Manager\ServiceManager;
use Throwable;

class Manager
    implements EventManager, RouteManager, ServiceManager
{
    /**
     *
     */
    use Events;

    /**
     * @param array|Definition $definition
     * @return Definition
     */
    public function definition($definition)
    {
        return $this->call(Args::ROUTE_DEFINITION, [Args::DEFINITION => $definition]);
    }

    /**
     * @param Route $route
     * @param Throwable $exception
     * @return RouteException
     */
    public function exception(Route $route, Throwable $exception)
    {
        return $this->call(Args::ROUTE_EXCEPTION, [Args::ROUTE => $route, Args::EXCEPTION => $exception]);
    }

    /**
     * @param Definition $definition
     * @param Route $route
     * @return Route
     */
    public function match(Definition $definition, Route $route)
    {
        return $this->trigger([RouteMatch::ROUTE, Args::DEFINITION => $definition, Args::ROUTE => $route], [], $this);
    }

    /**
     * @param Route $route
     * @param array $args
     * @return Route
     */
    public function route(Route $route, array $args = [])
    {
        return $this->trigger([RouteDispatch::DISPATCH, Args::ROUTE => $route], $args, $this);
    }
}
