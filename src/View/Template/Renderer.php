<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Model;
use Mvc5\Model\Template;

trait Renderer
{
    /**
     * @var string
     */
    protected $model;

    /**
     * @var View
     */
    protected $view;

    /**
     * @param View $view
     * @param string $model
     */
    function __construct(View $view, $model = Model::class)
    {
        $this->model = $model;
        $this->view  = $view;
    }

    /**
     * @param string|Template $template
     * @param array $config
     * @return string
     */
    function render($template, array $config = [])
    {
        !$template instanceof Template
            && $template = new $this->model($template);

        $config && $template->vars($config);

        return $this->view->render($template);
    }

    /**
     * @param string|Template $template
     * @param array $config
     * @return string
     */
    function __invoke($template, array $config = [])
    {
        return $this->render($template, $config);
    }
}
