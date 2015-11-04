<?php
/**
 *
 */

namespace Mvc5\Mvc\Layout;

use Mvc5\View\Layout\LayoutModel;
use Mvc5\View\Model\ViewModel;

interface Dispatch
{
    /**
     * @param LayoutModel $layout
     * @param $model
     * @return ViewModel
     */
    function __invoke(LayoutModel $layout, $model = null);
}
