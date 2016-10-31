<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;
use Mvc5\Model as _Model;
use Mvc5\Model\ViewModel as _ViewModel;

trait ViewModel
{
    /**
     * @param array $vars
     * @param null|string $template
     * @return _ViewModel
     */
    protected function model(array $vars = [], $template = null)
    {
        $model = $this->plugin(defined('static::VIEW_MODEL') ? constant('static::VIEW_MODEL') : Arg::VIEW_MODEL);

        !$template && $template = defined('static::TEMPLATE_NAME') ? constant('static::TEMPLATE_NAME') : null;

        $template && $model->template($template);

        $vars && $model->vars($vars);

        return $model;
    }

    /**
     * @param string $name
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    protected abstract function plugin($name, array $args = [], callable $callback = null);

    /**
     * @param string $template
     * @param array $vars
     * @return _ViewModel
     */
    protected function view($template = null, array $vars = [])
    {
        return $this->model($vars, $template);
    }
}
