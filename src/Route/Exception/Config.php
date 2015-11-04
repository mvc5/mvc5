<?php
/**
 *
 */

namespace Mvc5\Route\Exception;

use Mvc5\Route\Base;
use Mvc5\Route\Route;
use Throwable;

class Config
    implements RouteException
{
    /**
     *
     */
    use Base;

    /**
     * @return Throwable
     */
    public function exception()
    {
        return $this->get(self::EXCEPTION);
    }

    /**
     * @return Route
     */
    public function route()
    {
        return $this->get(self::ROUTE);
    }
}
