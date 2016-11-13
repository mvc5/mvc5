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
     * @var callable|null
     */
    protected $provider;

    /**
     * @param string $model
     * @return callable|mixed|null|object
     */
    protected function create($model)
    {
        return ($this->provider ? $this->call($this->provider, [$model]) : null) ? : new $this->model($model);
    }

    /**
     * @param $name
     * @return string
     */
    protected abstract function find($name);

    /**
     * @param array|string|Template $model
     * @param array $vars
     * @return Template
     */
    protected function model($model, array $vars = [])
    {
        !$model instanceof Template
            && $model = $this->create($model);

        $vars && $model->vars($vars);

        ($path = $model->template())
            && $model->template($this->find($path));

        $model instanceof ViewModel && !$model->service()
            && $model->service($this->service());

        return $model;
    }
}
