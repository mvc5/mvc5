<?php
/**
 *
 */

namespace Mvc5\View\Exception;

use Mvc5\View\Manager\ManageView;
use Throwable;

class Renderer
    implements Render
{
    /**
     *
     */
    use ManageView;

    /**
     * @param Throwable $exception
     * @param ExceptionModel $model
     * @return mixed
     */
    public function __invoke(Throwable $exception, ExceptionModel $model)
    {
        $model->exception($exception);

        return $this->render($model);
    }
}
