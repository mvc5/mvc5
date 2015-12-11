<?php
/**
 *
 */

namespace Mvc5\Route\Error;

use Mvc5\Arg;
use Mvc5\Route\Error;

class Create
{
    /**
     * @var Error
     */
    protected $route;

    /**
     * @param Error $route
     */
    public function __construct(Error $route)
    {
        $this->route = $route;
    }

    /**
     * @param $route
     * @return Error
     */
    public function __invoke($route)
    {
        $this->route->set(Arg::ROUTE, $route);

        return $this->route;
    }
}
