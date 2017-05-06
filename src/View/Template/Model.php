<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Arg;
use Mvc5\Service\Service;
use Mvc5\Template\TemplateModel;
use Mvc5\View\ViewModel;

trait Model
{
    /**
     * @var string
     */
    protected $model;

    /**
     * @var Service
     */
    protected $service;

    /**
     * @param string $model
     * @return TemplateModel
     */
    protected function create($model)
    {
        return (!is_string($model) || DIRECTORY_SEPARATOR !== $model[0] ? ($this->service)($model) : null) ?:
            new $this->model($model);
    }

    /**
     * @param $name
     * @return string
     */
    protected abstract function find($name);

    /**
     * @param array|string|TemplateModel $model
     * @param array $vars
     * @return TemplateModel
     */
    protected function model($model, array $vars = [])
    {
        /** @var TemplateModel $model */

        !($model instanceof TemplateModel)
            && $model = $this->create($model);

        ($path = $model->template()) && ($file = $this->find($path)) && ($path !== $file)
            && $vars[Arg::TEMPLATE_MODEL] = $file;

        $vars && $model = $model->with($vars);

        $model instanceof ViewModel && !$model->service()
            && $model = $model->withService($this->service);

        return $model;
    }
}
