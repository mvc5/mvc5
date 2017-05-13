<?php
/**
 *
 */

namespace Mvc5\View;

interface View
{
    /**
     * @param array|string|\Mvc5\Template\TemplateModel $template
     * @param array $vars
     * @return string
     */
    function render($template, array $vars = []);
}
