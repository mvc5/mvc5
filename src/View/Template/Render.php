<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Closure;
use Mvc5\Arg;
use Mvc5\Model\Template;
use Mvc5\Model\ViewModel;
use Mvc5\Plugin;
use RuntimeException;

trait Render
{
    /**
     *
     */
    use Plugin;
    use Templates;

    /**
     * @var null|string
     */
    protected $directory;

    /**
     * @var null|string
     */
    protected $extension = Arg::VIEW_EXTENSION;

    /**
     * @param array|\ArrayAccess $templates
     * @param string $directory
     * @param string $extension
     */
    function __construct($templates = [], $directory = null, $extension = null)
    {
        $this->directory = $directory;
        $this->templates = $templates;

        $extension && $this->extension = $extension;
    }

    /**
     * @param $name
     * @return string
     */
    protected function path($name)
    {
        return (!$name || !$this->directory || false !== strpos($name, '.')) ? $name :
            $this->directory . DIRECTORY_SEPARATOR . $name . '.' . $this->extension;
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

        $template = $model->template();

        ($template = $this->template($template) ?: $this->path($template))
            && $model->template($template);

        if (!$template) {
            throw new RuntimeException('Model template not found: ' . get_class($model));
        }

        $model instanceof ViewModel && !$model->service() && $model->service($this->service());

        $render = Closure::bind(function() {
                /** @var ViewModel $this */

                extract($this->vars());

                $__ob_level__ = ob_get_level();

                ob_start();

                try {

                    include $this->template();

                    return ob_get_clean();

                } catch (\Throwable $exception) {

                    while(ob_get_level() > $__ob_level__) {
                        ob_end_clean();
                    }

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
