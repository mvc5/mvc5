<?php
/**
 *
 */

namespace Mvc5\Template\Layout;

use Mvc5\Template\TemplateLayout;
use Mvc5\Template\TemplateModel;

trait Model
{
    /**
     * @param TemplateLayout $layout
     * @param $model
     * @return mixed|TemplateModel|TemplateLayout
     */
    protected function layout(TemplateLayout $layout, $model = null)
    {
        return !$model instanceof TemplateModel || $model instanceof TemplateLayout ? $model : $layout->withModel($model);
    }

    /**
     * @param TemplateLayout $layout
     * @param $model
     * @return mixed|TemplateModel|TemplateLayout
     */
    function __invoke(TemplateLayout $layout, $model = null)
    {
        return $this->layout($layout, $model);
    }
}
