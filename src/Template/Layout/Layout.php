<?php
/**
 *
 */

namespace Mvc5\Template\Layout;

use Mvc5\Template\TemplateLayout;
use Mvc5\Template\TemplateModel;

trait Layout
{
    /**
     * @var TemplateLayout
     */
    protected $layout;

    /**
     * @param TemplateLayout $layout
     */
    function __construct(TemplateLayout $layout)
    {
        $this->layout = $layout;
    }

    /**
     * @param TemplateLayout $layout
     * @param TemplateModel|mixed $model
     * @return TemplateLayout|mixed
     */
    protected function layout(TemplateLayout $layout, $model)
    {
        return !$model instanceof TemplateModel || $model instanceof TemplateLayout ? $model : $layout->withModel($model);
    }

    /**
     * @param TemplateModel|mixed $model
     * @return TemplateLayout|mixed
     */
    function __invoke($model = null)
    {
        return $this->layout($this->layout, $model);
    }
}
