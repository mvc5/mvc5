<?php
/**
 *
 */

namespace Mvc5\Route\Exception;

use Mvc5\Arg;
use Mvc5\Route\Exception;

class Controller
{
    /**
     * @var
     */
    protected $model;

    /**
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @param Exception $route
     * @return mixed
     */
    public function __invoke(Exception $route)
    {
        $this->model[Arg::EXCEPTION] = $route->exception();

        return $this->model;
    }
}
