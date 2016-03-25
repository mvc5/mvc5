<?php
/**
 *
 */

namespace Mvc5\Route\Error;

use Mvc5\Arg;
use Mvc5\View\Model as ViewModel;
use Mvc5\Response\Error;
use Mvc5\Route\Route;

class Controller
{
    /**
     *
     */
    use ViewModel;

    /**
     * @param Route $route
     * @param Error $error
     * @return mixed
     */
    public function __invoke(Route $route, Error $error = null)
    {
        return $this->model([Arg::ERROR => $error ?? $route->error()]);
    }
}
