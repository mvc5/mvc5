<?php
/**
 *
 */

namespace Mvc5\Request\Exception;

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
    function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @param array|\ArrayAccess $request
     * @return mixed
     */
    function __invoke($request)
    {
        $this->model[Arg::EXCEPTION] = $request[Arg::EXCEPTION];

        return $this->model;
    }
}
