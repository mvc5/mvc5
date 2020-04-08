<?php
/**
 *
 */

namespace Mvc5\View\Engine;

use Mvc5\Template\TemplateModel;
use Mvc5\View\ViewEngine;

use function Mvc5\Template\render;

class PhpEngine
    implements ViewEngine
{
    /**
     * @param  TemplateModel $template
     * @return string
     */
    function render(TemplateModel $template) : string
    {
        return render($template);
    }
}
