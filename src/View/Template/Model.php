<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Model as _Model;
use Mvc5\Model\Template;
use Mvc5\Model\ViewModel;
use Mvc5\Plugin;

trait Model
{
    /**
     *
     */
    use Plugin;

    /**
     * @var string
     */
    protected $model = _Model::class;

    /**
     * @param $model
     * @return mixed
     */
    protected function create($model)
    {
        return new $this->model($model);
    }

    /**
     * @param $name
     * @return string
     */
    protected abstract function find($name);

    /**
     * @param array|string|Template $model
     * @param array $vars
     * @param callable $callback
     * @return Template
     */
    protected function model($model, array $vars = [], callable $callback = null)
    {
        !$model instanceof Template
            && $model = $this->create($model);

        $vars && $model->vars($vars);

        ($path = $model->template())
            && $model->template($this->find($path));

        $model instanceof ViewModel && !$model->service()
            && $model->service($this->service());

        return $callback ? $callback($model) : $model;
    }
}
