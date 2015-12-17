<?php
/**
 *
 */

namespace Mvc5\Mvc;

use Mvc5\Plugin;
use Mvc5\View\Renderer;
use Throwable;

class View
{
    /**
     *
     */
    use Plugin;
    use Renderer;

    /**
     * @param $model
     * @return mixed
     */
    public function __invoke($model = null)
    {
        if (!$model) {
            return $model;
        }

        try {

            return $this->render($model);

        } catch (Throwable $exception) {

            return $this->exception($exception, $model);

        }
    }
}
