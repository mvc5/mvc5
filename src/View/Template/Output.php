<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Model\Template;

trait Output
{
    /**
     * @var bool
     */
    protected $checkFileExists = false;

    /**
     * @param  Template $template
     * @return string
     */
    protected function output(Template $template)
    {
        !($file = $template->template()) && NotFound::missing($template);

        $this->checkFileExists && !file_exists($file) && NotFound::file($file);

        $render = \Closure::bind(function($__template) {
            /** @var Template $this */

            extract($this->vars(), EXTR_SKIP);

            $__ob_level__ = ob_get_level();

            ob_start();

            try {

                include $__template;

                return ob_get_clean();

            } catch(\Throwable $exception) {
                while(ob_get_level() > $__ob_level__) {
                    ob_end_clean();
                }

                throw $exception;
            }
        },
            $template,
            $template
        );

        return $render($file);
    }
}
