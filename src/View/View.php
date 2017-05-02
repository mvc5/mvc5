<?php
/**
 *
 */

namespace Mvc5\View;

use Mvc5\Template\TemplateModel;

interface View
{
    /**
     * @param array|string|TemplateModel $template
     * @param array $vars
     * @return string
     */
    function render($template, array $vars = []);
}
