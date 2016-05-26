<?php
/**
 *
 */

namespace Mvc5\Request\Exception;

use Mvc5\Arg;
use Mvc5\Http\Request;

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
     * @param Request $request
     * @return mixed
     */
    function __invoke(Request $request)
    {
        $this->model[Arg::EXCEPTION] = $request[Arg::EXCEPTION];

        return $this->model;
    }
}
