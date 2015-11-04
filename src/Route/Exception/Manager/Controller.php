<?php
/**
 *
 */

namespace Mvc5\Route\Exception\Manager;

use Mvc5\Route\Exception\RouteException;
use Mvc5\View\Model\ViewModel;

class Controller
    implements Dispatch
{
    /**
     *
     */
    use ManageException;

    /**
     * @param RouteException $route
     * @return ViewModel
     */
    public function __invoke(RouteException $route)
    {
        return $this->exception($route->route(), $route->exception());
    }
}
