<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Template\TemplateModel;

trait Traverse
{
    /**
     * @param array|string|TemplateModel $template
     * @param array $vars
     * @return string
     */
    protected abstract function render($template, array $vars = []);

    /**
     * @param TemplateModel $template
     * @param array $vars
     * @return TemplateModel
     */
    protected function traverse(TemplateModel $template, array $vars = [])
    {
        foreach($template as $k => $v) {
            $v instanceof TemplateModel && $vars[$k] = $this->render($v);
        }

        return $vars ? $template->with($vars) : $template;
    }
}
