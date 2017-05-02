<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Template\TemplateModel;
use Mvc5\View\ViewEngine;

trait Render
{
    /**
     *
     */
    use Traverse;

    /**
     * @var ViewEngine
     */
    protected $engine;

    /**
     * @param array|string|TemplateModel $model
     * @param array $vars
     * @return TemplateModel
     */
    protected abstract function model($model, array $vars = []);

    /**
     * @param array|string|TemplateModel $template
     * @param array $vars
     * @return string
     */
    function render($template, array $vars = [])
    {
        return $this->engine->render($this->traverse($this->model($template, $vars)));
    }

    /**
     * @param $model
     * @param array $vars
     * @return mixed
     */
    function __invoke($model = null, array $vars = [])
    {
        return !$model instanceof TemplateModel ? $model : $this->render($model, $vars);
    }
}
