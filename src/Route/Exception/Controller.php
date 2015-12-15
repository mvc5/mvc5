<?php
/**
 *
 */

namespace Mvc5\Route\Exception;

use Mvc5\Arg;

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
     * @param $route
     * @return mixed
     */
    public function __invoke($route)
    {
        $this->model[Arg::EXCEPTION] = $route[Arg::EXCEPTION];

        return $this->model;
    }
}
