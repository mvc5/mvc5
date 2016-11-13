<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Model\Template;
use Mvc5\Model\Layout as _Layout;

class Layout
{
    /**
     * @param _Layout $layout
     * @param mixed|Template $model
     * @return _Layout
     */
    function __invoke(_Layout $layout, $model)
    {
        $layout->model($model);

        return $layout;
    }
}
