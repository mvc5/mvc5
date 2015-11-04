<?php
/**
 *
 */

namespace Mvc5\View\Manager;

use Mvc5\View\Model\ViewModel;
use Throwable;

trait ManageView
{
    /**
     * @var ViewManager
     */
    protected $vm;

    /**
     * @param array|callable|object|string $name
     * @param array $args
     * @return callable|mixed|null|object
     */
    public function call($name, array $args = [])
    {
        return $this->vm->call($name, $args);
    }

    /**
     * @param Throwable $exception
     * @return mixed
     */
    public function exception(Throwable $exception)
    {
        return $this->vm->exception($exception);
    }

    /**
     * @param string $name
     * @param callable $callback
     * @param array $args
     * @return null|callable|object
     */
    public function plugin($name, array $args = [], callable $callback = null)
    {
        return $this->vm->plugin($name, $args, $callback);
    }

    /**
     * @param ViewModel $model
     * @return mixed
     */
    public function render(ViewModel $model)
    {
        return $this->vm->render($model);
    }

    /**
     * @param ViewManager $vm
     */
    public function setViewManager(ViewManager $vm)
    {
        $this->vm = $vm;
    }

    /**
     * @return ViewManager
     */
    public function viewManager()
    {
        return $this->vm;
    }
}
