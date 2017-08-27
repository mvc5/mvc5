<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;

trait View
{
    /**
     * @param array $vars
     * @param string $template
     * @param string $model
     * @return \Mvc5\Template\TemplateLayout|mixed
     */
    protected function layout(array $vars = [], string $template = null, $model = Arg::LAYOUT)
    {
        return $this->model($vars, $template, $model);
    }

    /**
     * @param array $vars
     * @param null|string $template
     * @param $model
     * @return \Mvc5\Template\TemplateModel|\Mvc5\Template\TemplateLayout|mixed
     */
    protected function model(array $vars = [], string $template = null, $model = null)
    {
        !$model && $model = defined('static::VIEW_MODEL') ? constant('static::VIEW_MODEL') : Arg::VIEW_MODEL;

        !$template && defined('static::TEMPLATE') && $template = constant('static::TEMPLATE');

        $template && $vars[Arg::TEMPLATE_MODEL] = $template;

        return !$vars ? $this->plugin($model) : $this->plugin($model)->with($vars);
    }

    /**
     * @param $name
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    protected abstract function plugin($name, array $args = [], callable $callback = null);

    /**
     * @param string $template
     * @param array $vars
     * @return \Mvc5\Template\TemplateModel|mixed
     */
    protected function view(string $template = null, array $vars = [])
    {
        return $this->model($vars, $template);
    }
}
