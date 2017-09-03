<?php
/**
 *
 */

namespace Mvc5\Request\Exception;

use Mvc5\Arg;
use Mvc5\Template\TemplateModel;
use Mvc5\Http\Request;

class Controller
{
    /**
     * @var TemplateModel
     */
    protected $model;

    /**
     * @param TemplateModel $model
     */
    function __construct(TemplateModel $model)
    {
        $this->model = $model;
    }

    /**
     * @param Request $request
     * @return TemplateModel
     */
    function __invoke(Request $request) : TemplateModel
    {
        return $this->model->with(Arg::EXCEPTION, $request[Arg::EXCEPTION]);
    }
}
