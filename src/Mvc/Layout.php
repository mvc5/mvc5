<?php
/**
 *
 */

namespace Mvc5\Mvc;

use Mvc5\Model\Layout as LayoutModel;
use Mvc5\Model\ViewModel;

class Layout
{
    /**
     * @param LayoutModel $layout
     * @param $model
     * @return null|ViewModel|LayoutModel
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
