<?php
/**
 *
 */

namespace Mvc5\Mvc\Layout;

use Mvc5\View\Layout\LayoutModel;
use Mvc5\View\Model\ViewModel;

class Renderer
    implements Dispatch
{
    /**
     * @param LayoutModel $layout
     * @param $model
     * @return ViewModel
     */
    public function __invoke(LayoutModel $layout, $model = null)
    {
        if (!$model || !$model instanceof ViewModel || $model instanceof LayoutModel) {
            return $model;
        }

        $layout->child($model);

        return $layout;
    }
}
