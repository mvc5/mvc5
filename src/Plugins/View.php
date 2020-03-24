<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Template\TemplateLayout;
use Mvc5\Template\TemplateModel;

use function constant;
use function defined;

use const Mvc5\{ LAYOUT, TEMPLATE_MODEL, VIEW_MODEL };

trait View
{
    /**
     * @param array $vars
     * @param string|null $template
     * @param string $model
     * @return TemplateLayout|mixed
     */
    protected function layout(array $vars = [], string $template = null, string $model = LAYOUT) : TemplateLayout
    {
        return $this->model($vars, $template, $model);
    }

    /**
     * @param array $vars
     * @param string|null $template
     * @param string|null $model
     * @return TemplateModel|mixed
     */
    protected function model(array $vars = [], string $template = null, string $model = null) : TemplateModel
    {
        !$model && $model = defined('static::VIEW_MODEL') ? constant('static::VIEW_MODEL') : VIEW_MODEL;

        !$template && defined('static::TEMPLATE') && $template = constant('static::TEMPLATE');

        $template && $vars[TEMPLATE_MODEL] = $template;

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
     * @return TemplateModel|mixed
     */
    protected function view(string $template = null, array $vars = []) : TemplateModel
    {
        return $this->model($vars, $template);
    }
}
