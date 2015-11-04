<?php
/**
 *
 */

namespace Mvc5\Controller\Manager;

use Throwable;
use Mvc5\Controller\Dispatch\Controller;
use Mvc5\Controller\Exception\DispatchException;
use Mvc5\Event\Manager\EventManager;
use Mvc5\Event\Manager\Events;
use Mvc5\Service\Manager\ServiceManager;

class Manager
    implements ControllerManager, EventManager, ServiceManager
{
    /**
     *
     */
    use Events;

    /**
     * @param callable $controller
     * @param array $args
     * @return mixed
     */
    public function action(callable $controller, array $args = [])
    {
        return $this->call($controller, $args, $this);
    }

    /**
     * @param array|callable|object|string $config
     * @return callable
     */
    public function controller($config)
    {
        return $this->invokable($config);
    }

    /**
     * @param callable $controller
     * @param array $args
     * @return mixed
     */
    public function dispatch(callable $controller, array $args = [])
    {
        return $this->trigger([Controller::DISPATCH, Args::CONTROLLER => $controller], $args, $this);
    }

    /**
     * @param Throwable $exception
     * @param array $args
     * @return mixed
     */
    public function exception(Throwable $exception, array $args = [])
    {
        return $this->trigger([DispatchException::EXCEPTION, Args::EXCEPTION => $exception], $args, $this);
    }
}
