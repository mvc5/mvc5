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
     * @param mixed $request
     * @return mixed
     */
    function __invoke($request)
    {
        try {

            return $this->route($request);

        } catch (Throwable $exception) {

            return $this->exception($exception, $request);

        }
    }
}
