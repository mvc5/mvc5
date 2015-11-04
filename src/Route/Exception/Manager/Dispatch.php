<?php
/**
 *
 */

namespace Mvc5\Route\Exception\Manager;

use Mvc5\Route\Exception\RouteException;
use Mvc5\View\Model\ViewModel;

interface Dispatch
{
    /**
     * @param RouteException $route
     * @return ViewModel
     */
    function __invoke(RouteException $route);
}
