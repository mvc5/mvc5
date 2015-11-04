<?php
/**
 *
 */

namespace Mvc5\View;

use Mvc5\View\Model\Model as Base;
use Mvc5\View\Model\ViewModel as Model;

trait ViewModel
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @param Model $model
     * @return void
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $vars
     * @return Model
     */
    public function model(array $vars = [])
    {
        !$this->model && $this->model = new Base;

        $vars && $this->model->vars($vars);

        return $this->model;
    }

    /**
     * @param string $template
     * @param array $vars
     * @return Model
     */
    public function view($template = null, array $vars = [])
    {
        $this->model($vars);

        $template && $this->model->template($template);

        return $this->model;
    }
}
