<?php
/**
 *
 */

namespace Mvc5\View;

use Mvc5\Template\TemplateModel;

class Renderer
{
    /**
     * @var View
     */
    protected $view;

    /**
     * @param View $view
     */
    function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * @param array|string|TemplateModel $model
     * @param array $vars
     * @return string
     */
    function __invoke($model, array $vars = [])
    {
        return $this->view->render($model, $vars);
    }
}
