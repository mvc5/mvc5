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
     * @var callable|null
     */
    protected $provider;

    /**
     * @var Service
     */
    protected $service;

    /**
     * @param string $model
     * @param array $vars
     * @return TemplateModel
     */
    protected function create($model, array $vars = [])
    {
        return ($this->provider ? ($this->provider)($model, $vars) : null) ? : new $this->model($model, $vars);
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

        $model = is_string($model) ? $this->create($model, $vars) : (
            is_array($model) ? $this->create($model + ($vars ? [Arg::VARS => $vars] : [])) : (
                $vars ? $model->with($vars) : $model
            )
        );

        ($path = $model->template()) && ($file = $this->find($path)) && ($path !== $file)
            && $model = $model->withTemplate($file);

        $model instanceof ViewModel && !$model->service()
            && $model = $model->withService($this->service);

        return $model;
    }
}
