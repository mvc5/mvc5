<?php
/**
 *
 */

namespace Mvc5\Route\Exception\Manager;

use Mvc5\Event\Manager\EventManager;
use Mvc5\Event\Manager\Events;
use Mvc5\Route\Exception\DispatchException;
use Mvc5\Route\Route;
use Mvc5\Service\Manager\ServiceManager;
use Mvc5\View\Model\ViewModel;
use Throwable;

class Manager
    implements EventManager, ExceptionManager, ServiceManager
{
    /**
     *
     */
    use Events;

    /**
     * @param Route $route
     * @param Throwable $exception
     * @return ViewModel
     */
    public function exception(Route $route, Throwable $exception)
    {
        return $this->trigger([DispatchException::EXCEPTION, Args::ROUTE => $route, Args::EXCEPTION => $exception], [], $this);
    }
}
