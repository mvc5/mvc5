<?php
/**
 *
 */

namespace Mvc5\Request\Error;

use Mvc5\Arg;
use Mvc5\Http\Error;
use Mvc5\Http\Request;

class Controller
{
    /**
     * @var ErrorModel
     */
    protected $model;

    /**
     * @param ErrorModel $model
     */
    function __construct(ErrorModel $model)
    {
        $this->model = $model;
    }

    /**
     * @param Request $request
     * @param Error $error
     * @return mixed
     */
    function __invoke(Request $request, Error $error = null)
    {
        return $this->model->with([Arg::ERROR => $error ?: $request[Arg::ERROR]]);
    }
}
