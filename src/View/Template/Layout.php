<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Model\Template;
use Mvc5\Model\ViewLayout;

class Layout
{
    /**
     * @param ViewLayout $layout
     * @param Template $model
     * @return ViewLayout
     */
    public function __invoke(ViewLayout $layout, Template $model)
    {
        $layout->model($model);

        return $layout;
    }
}
