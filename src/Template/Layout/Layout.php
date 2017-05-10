<?php
/**
 *
 */

namespace Mvc5\Template\Layout;

use Mvc5\Template\TemplateLayout;
use Mvc5\Template\TemplateModel;
use Mvc5\View\ViewLayout;

trait Layout
{
    /**
     * @var ViewLayout
     */
    protected $layout;

    /**
     * @param ViewLayout $layout
     */
    function __construct(ViewLayout $layout)
    {
        $this->layout = $layout;
    }

    /**
     * @param TemplateLayout $layout
     * @param $model
     * @return mixed|TemplateModel|TemplateLayout
     */
    protected function layout(TemplateLayout $layout, $model)
    {
        return !$model instanceof TemplateModel || $model instanceof TemplateLayout ? $model : $layout->withModel($model);
    }

    /**
     * @param $model
     * @return mixed|TemplateModel|TemplateLayout
     */
    function __invoke($model = null)
    {
        return $this->layout($this->layout, $model);
    }
}
