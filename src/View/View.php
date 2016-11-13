<?php
/**
 *
 */

namespace Mvc5\View;

use Mvc5\Model\Template;

interface View
{
    /**
     * @param array|string|Template $template
     * @param array $vars
     * @return string
     */
    function render($template, array $vars = []);
}
