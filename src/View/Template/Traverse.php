<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Template\TemplateModel;

trait Traverse
{
    /**
     * @param TemplateModel $template
     * @param array $vars
     * @return TemplateModel
     */
    protected function traverse(TemplateModel $template, array $vars = []) : TemplateModel
    {
        foreach($template as $k => $v) {
            $v instanceof TemplateModel && $vars[$k] = $this->render($v);
        }

        return $vars ? $template->with($vars) : $template;
    }
}
