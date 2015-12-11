<?php
/**
 *
 */

namespace Mvc5\Mvc;

use Mvc5\Plugin;
use Mvc5\Route\Dispatcher;
use Throwable;

class Route
{
    /**
     *
     */
    use Plugin;
    use Dispatcher;

    /**
     * @param mixed $route
     * @return mixed
     */
    public function __invoke($route)
    {
        try {

            return $this->route($route);

        } catch (Throwable $exception) {

            return $this->exception($exception, $route);

        }
    }
}
