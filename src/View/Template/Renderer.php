<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Closure;
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
     * @param mixed|ViewModel $model
     * @return string
     */
    public function __invoke($model)
    {
        if (!$model instanceof ViewModel) {
            return $model;
        }

        /** @var ViewModel $model */

        foreach($model as $k => $v) {
            $v instanceof ViewModel && $model->set($k, $this($v));
        }

        ($template = $this->template($model->path()))
            && $model->template($template);

        if (!$model->path()) {
            throw new RuntimeException('View model path not found: ' . get_class($model));
        }

        !$model->service() && $model->service($this->service());

        $render = Closure::bind(function() {
            /** @var ViewModel $this */

            extract($this->assigned());

            ob_start();

            try {

                include $this->path();

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
