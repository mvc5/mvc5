<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Model\Template;

trait Traverse
{
    /**
     * @param array|string|Template $template
     * @param array $vars
     * @return string
     */
    protected abstract function render($template, array $vars = []);

    /**
     * @param Template $template
     * @return Template
     */
    protected function traverse(Template $template)
    {
        foreach($template as $k => $v) {
            $v instanceof Template && $template[$k] = $this->render($v);
        }

        return $template;
    }
}
