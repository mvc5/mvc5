<?php
/**
 *
 */

namespace Mvc5\View;

use Mvc5\Model as Mvc5Model;
use Mvc5\Model\ViewModel;

trait Model
{
    /**
     * @var ViewModel
     */
    protected $model;

    /**
     * @param ViewModel $model
     * @return void
     */
    function setModel(ViewModel $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $vars
     * @return ViewModel
     */
    function model(array $vars = [])
    {
        !$this->model && $this->model = new Mvc5Model;

        $vars && $this->model->vars($vars);

        return $this->model;
    }

    /**
     * @param string $template
     * @param array $vars
     * @return ViewModel
     */
    function view($template = null, array $vars = [])
    {
        $this->model($vars);

        $template && $this->model->template($template);

        return $this->model;
    }
}
