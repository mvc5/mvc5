<?php
/**
 *
 */

namespace Mvc5\View\Manager;

use Mvc5\View\Model\ViewModel;
use Throwable;

interface ViewManager
{
    /**
     * @param array|callable|object|string $name
     * @param array $args
     * @param callable $callback
     * @return null|callable|object
     */
    function call($name, array $args = [], callable $callback = null);

    /**
     * @param Throwable $exception
     * @return mixed
     */
    function exception(Throwable $exception);

    /**
     * @param $name
     * @return mixed
     */
    function param($name);

    /**
     * @param string $name
     * @param callable $callback
     * @param array $args
     * @return null|callable|object
     */
    function plugin($name, array $args = [], callable $callback = null);

    /**
     * @param ViewModel $model
     * @return mixed
     */
    function render(ViewModel $model);
}
