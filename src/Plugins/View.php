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
     * @param string|null $template
     * @param string $model
     * @return \Mvc5\Template\TemplateLayout|mixed
     */
    protected function layout(array $vars = [], string $template = null, string $model = Arg::LAYOUT)
    {
        return $this->model($vars, $template, $model);
    }

    /**
     * @param array $vars
     * @param string|null $template
     * @param string|null $model
     * @return \Mvc5\Template\TemplateModel|\Mvc5\Template\TemplateLayout|mixed
     */
    protected function model(array $vars = [], string $template = null, string $model = null)
    {
        !$model && $model = defined('static::VIEW_MODEL') ? constant('static::VIEW_MODEL') : Arg::VIEW_MODEL;

        !$template && defined('static::TEMPLATE') && $template = constant('static::TEMPLATE');

        $template && $vars[Arg::TEMPLATE_MODEL] = $template;

        return !$vars ? $this->plugin($model) : $this->plugin($model)->with($vars);
    }

    /**
     * @param string|mixed $plugin
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     */
    protected abstract function plugin($plugin, array $args = [], callable $callback = null);

    /**
     * @param string|null $template
     * @param array $vars
     * @return \Mvc5\Template\TemplateModel|mixed
     */
    protected function view(string $template = null, array $vars = [])
    {
        return $this->model($vars, $template);
    }
}
