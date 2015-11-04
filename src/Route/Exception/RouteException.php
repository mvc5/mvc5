<?php
/**
 *
 */

namespace Mvc5\Route\Exception;

use Mvc5\Route\Route;
use Throwable;

interface RouteException
    extends Route
{
    /**
     *
     */
    const EXCEPTION = 'exception';

    /**
     *
     */
    const ROUTE = 'route';

    /**
     * @return Throwable
     */
    function exception();

    /**
     * @return Route
     */
    function route();
}
