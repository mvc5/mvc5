<?php
/**
 *
 */

namespace Mvc5\View\Engine;

use Mvc5\Template\TemplateModel;
use Mvc5\View\ViewEngine;

class PhpEngine
    implements ViewEngine
{
    /**
     * @param  TemplateModel $template
     * @return string
     */
    function render(TemplateModel $template) : string
    {
        return (function() {
            /** @var TemplateModel $this */

            extract($this->vars(), EXTR_SKIP);

            $__ob_level__ = ob_get_level();

            ob_start();

            try {

                include $this->template();

                return ob_get_clean();

            } catch(\Throwable $exception) {
                while(ob_get_level() > $__ob_level__) {
                    ob_end_clean();
                }

                throw $exception;
            }
        })->call($template);
    }
}
