<?php
/**
 *
 */

namespace Mvc5\Controller;

use Mvc5\Arg;
use Throwable;

class Exception
{
    /**
     * @var
     */
    protected $model;

    /**
     * @param $model
     */
    function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @param Throwable $exception
     * @return mixed
     */
    function __invoke(Throwable $exception)
    {
        $this->model[Arg::EXCEPTION] = $exception;

        return $this->model;
    }
}
