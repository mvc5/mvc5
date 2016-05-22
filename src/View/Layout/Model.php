<?php
/**
 *
 */

namespace Mvc5\View\Layout;

use Mvc5\Model\Layout as LayoutModel;
use Mvc5\Model\Template as ViewModel;

trait Model
{
    /**
     * @param LayoutModel $layout
     * @param $model
     * @return null|ViewModel|LayoutModel
     */
    protected function model(LayoutModel $layout, $model = null)
    {
        if (!$model || !$model instanceof ViewModel || $model instanceof LayoutModel) {
            return $model;
        }

        $layout->model($model);

        return $layout;
    }

    /**
     * @param LayoutModel $layout
     * @param $model
     * @return null|ViewModel|LayoutModel
     */
    function __invoke(LayoutModel $layout, $model = null)
    {
        return $this->model($layout, $model);
    }
}
