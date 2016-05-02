<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Model\Template;
use Mvc5\Model\Layout as TemplateLayout;

class Layout
{
    /**
     * @param TemplateLayout $layout
     * @param mixed|Template $model
     * @return TemplateLayout
     */
    function __invoke(TemplateLayout $layout, $model)
    {
        $layout->model($model);

        return $layout;
    }
}
