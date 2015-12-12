<?php
/**
 *
 */

namespace Mvc5\Mvc;

use Mvc5\Model\Layout as LayoutModel;
use Mvc5\Model\Template as ViewModel;

class Layout
{
    /**
     * @param LayoutModel $layout
     * @param $model
     * @return null|ViewModel|Layout
     */
    public function __invoke(LayoutModel $layout, $model = null)
    {
        if (!$model || !$model instanceof ViewModel || $model instanceof LayoutModel) {
            return $model;
        }

        $layout->model($model);

        return $layout;
    }
}
