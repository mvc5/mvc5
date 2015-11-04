<?php
/**
 *
 */

namespace Mvc5\Route\Exception\Manager;

use Mvc5\Route\Route;
use Mvc5\View\Model\ViewModel;
use Throwable;

interface ExceptionManager
{
    /**
     * @param Route $route
     * @param Throwable $exception
     * @return ViewModel
     */
    function exception(Route $route, Throwable $exception);
}
