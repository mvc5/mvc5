<?php
/**
 *
 */

namespace Mvc5\View;

trait ViewTemplates
{
    /**
     * @var array|\ArrayAccess
     */
    protected $templates = [];

    /**
     * @param string $template
     * @return string
     */
    public function template($template)
    {
        return isset($this->templates[$template]) ? $this->templates[$template] : null;
    }

    /**
     * @param array|\ArrayAccess $templates
     */
    public function templates($templates)
    {
        $this->templates = $templates;
    }
}
