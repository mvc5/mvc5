<?php
/**
 *
 */

namespace Mvc5\View;

use Mvc5\Model\Template;

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
     * @param array|string|Template $model
     * @param array $vars
     * @return string
     */
    function __invoke($model, array $vars = [])
    {
        return $this->view->render($model, $vars);
    }
}
