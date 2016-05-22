<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Closure;
use Mvc5\Model\Template;
use Mvc5\Model\ViewModel;
use Mvc5\Plugin;
use RuntimeException;
use Throwable;

trait Render
{
    /**
     *
     */
    use Plugin;
    use Templates;

    /**
     * @param $templates
     */
    function __construct($templates = [])
    {
        $this->templates = $templates;
    }

    /**
     * @param Template|ViewModel $model
     * @return string
     */
    function render(Template $model)
    {
        foreach($model as $k => $v) {
            $v instanceof Template && $model[$k] = $this->render($v);
        }

        ($template = $this->template($model->template()))
            && $model->template($template);

        if (!$model->template()) {
            throw new RuntimeException('Model template not found: ' . get_class($model));
        }

        $model instanceof ViewModel && !$model->service() && $model->service($this->service());

        $render = Closure::bind(function() {
            /** @var ViewModel $this */

            extract($this->vars());

            ob_start();

            try {

                include $this->template();

                return ob_get_clean();

            } catch (Throwable $exception) {

                ob_get_clean();

                throw $exception;
            }
        },
            $model,
            $model
        );

        return $render();
    }

    /**
     * @param $model
     * @return mixed
     */
    function __invoke($model = null)
    {
        return !$model instanceof Template ? $model : $this->render($model);
    }
}
