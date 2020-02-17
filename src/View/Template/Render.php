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
    protected ViewEngine $engine;

    /**
     * @param array|string|TemplateModel $template
     * @param array $vars
     * @return string
     */
    function render($template, array $vars = []) : string
    {
        return $this->engine->render($this->traverse($this->model($template, $vars)));
    }

    /**
     * @param TemplateModel|mixed $model
     * @param array $vars
     * @return string|mixed
     */
    function __invoke($model = null, array $vars = [])
    {
        return !$model instanceof TemplateModel ? $model : $this->render($model, $vars);
    }
}
