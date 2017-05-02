<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;
use Mvc5\Template\TemplateModel;
use Mvc5\Template\TemplateLayout;

trait ViewModel
{
    /**
     * @param array $vars
     * @param string $template
     * @param string $model
     * @return mixed|TemplateLayout
     */
    protected function layout(array $vars = [], $template = null, $model = Arg::LAYOUT)
    {
        return $this->plugin($model, array_filter([Arg::TEMPLATE => $template, Arg::VARS => $vars]));
    }

    /**
     * @param array $vars
     * @param null|string $template
     * @return mixed|TemplateModel|TemplateLayout
     */
    protected function model(array $vars = [], $template = null)
    {
        !$template && defined('static::TEMPLATE_NAME')
            && $template = constant('static::TEMPLATE_NAME');

        $model = defined('static::VIEW_MODEL') ? constant('static::VIEW_MODEL') : Arg::VIEW_MODEL;

        return $this->plugin($model, [$template, $vars]);
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
     * @return TemplateModel
     */
    protected function view($template = null, array $vars = [])
    {
        return $this->model($vars, $template);
    }
}
