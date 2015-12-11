<?php
/**
 *
 */

namespace Mvc5\Route\Exception;

use Mvc5\Arg;
use Mvc5\Route\Exception;
use Throwable;

class Create
{
    /**
     * @var Exception
     */
    protected $route;

    /**
     * @param Exception $route
     */
    public function __construct(Exception $route)
    {
        $this->route = $route;
    }

    /**
     * @param Throwable $exception
     * @param $route
     * @return Exception
     */
    public function __invoke(Throwable $exception, $route)
    {
        $this->route->set(Arg::EXCEPTION, $exception);
        $this->route->set(Arg::ROUTE, $route);

        return $this->route;
    }
}
