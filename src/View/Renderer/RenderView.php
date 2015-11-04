<?php
/**
 *
 */

namespace Mvc5\View\Renderer;

use Closure;
use Mvc5\View\Manager\ViewManager;
use Mvc5\View\Model\Plugin;
use Mvc5\View\Model\ViewModel;
use RuntimeException;
use Throwable;

trait RenderView
{
    /**
     * @param string $template
     * @return string
     */
    protected abstract function template($template);

    /**
     * @return ViewManager
     */
    protected abstract function viewManager();

    /**
     * @param ViewModel $model
     * @return string
     */
    public function __invoke(ViewModel $model)
    {
        foreach($model as $k => $v) {
            $v instanceof ViewModel && $model->set($k, $this($v));
        }

        if ($template = $this->template($model->path())) {
            $model->template($template);
        }

        if (!$model->path()) {
            throw new RuntimeException('View model path not found: ' . get_class($model));
        }

        $model instanceof Plugin
            && !$model->viewManager() && $model->setViewManager($this->viewManager());

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
