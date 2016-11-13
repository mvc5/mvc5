<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Model\Template;

trait Render
{
    /**
     *
     */
    use Output;
    use Traverse;

    /**
     * @param array|string|Template $model
     * @param array $vars
     * @return Template
     */
    protected abstract function model($model, array $vars = []);

    /**
     * @param array|string|Template $template
     * @param array $vars
     * @return string
     */
    function render($template, array $vars = [])
    {
        return $this->output($this->traverse($this->model($template, $vars)));
    }

    /**
     * @param $model
     * @param array $vars
     * @return mixed
     */
    function __invoke($model = null, array $vars = [])
    {
        return !$model instanceof Template ? $model : $this->render($model, $vars);
    }
}
