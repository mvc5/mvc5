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

class Renderer
    implements View
{
    /**
     *
     */
    use Plugin;
    use Templates;

    /**
     * @param $templates
     */
    public function __construct($templates)
    {
        $this->templates = $templates;
    }

    /**
     * @param mixed|Template|ViewModel $model
     * @return string
     */
    public function __invoke($model)
    {
        if (!$model instanceof Template) {
            return null;
        }

        foreach($model as $k => $v) {
            $v instanceof Template && $model[$k] = $this($v);
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
            $model
        );

        return $render();
    }
}
