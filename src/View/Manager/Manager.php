<?php
/**
 *
 */

namespace Mvc5\View\Manager;

use Mvc5\Event\Manager\EventManager;
use Mvc5\Event\Manager\Events;
use Mvc5\Service\Manager\ServiceManager;
use Mvc5\View\Exception\ViewException;
use Mvc5\View\Model\ViewModel;
use Mvc5\View\Render\Render;
use Throwable;

class Manager
    implements EventManager, ServiceManager, ViewManager
{
    /**
     *
     */
    use Events;

    /**
     * @param Throwable $exception
     * @return mixed
     */
    public function exception(Throwable $exception)
    {
        return $this->trigger([ViewException::VIEW, Args::EXCEPTION => $exception], [], $this);
    }

    /**
     * @param ViewModel $model
     * @param array $args
     * @return mixed
     */
    public function render(ViewModel $model, array $args = [])
    {
        return $this->trigger([Render::VIEW, Args::MODEL => $model], $args, $this);
    }
}
