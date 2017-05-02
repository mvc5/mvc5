<?php
/**
 *
 */

namespace Mvc5\Request\Error;

use Mvc5\Arg;
use Mvc5\Http\Error as HttpError;
use Mvc5\Http\Request;

class Controller
{
    /**
     * @param ErrorModel $model
     */
    function __construct(ErrorModel $model)
    {
        $this->model = $model;
    }

    /**
     * @param Request $request
     * @param HttpError $error
     * @return mixed
     */
    function __invoke(Request $request, HttpError $error = null)
    {
        return $this->model->with([Arg::ERROR => $error ?: $request[Arg::ERROR]]);
    }
}
