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
     * @param null|string $template
     * @return ViewModel
     */
    function model(array $vars = [], $template = null)
    {
        if (!$this->model) {
            $this->model = (defined('static::VIEW_MODEL') && $model = constant('static::VIEW_MODEL'))
                ? new $model : new Mvc5Model;

            !$template && $template = defined('static::TEMPLATE_NAME') ? constant('static::TEMPLATE_NAME') : null;
        }

        $template && $this->model->template($template);

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
        return $this->model($vars, $template);
    }
}
