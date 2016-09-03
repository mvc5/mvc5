<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Model\Template;

interface ViewRenderer
{
    /**
     * @param string|Template $template
     * @param array $config
     * @return string
     */
    function render($template, array $config = []);
}
