<?php
/**
 *
 */

namespace Mvc5\Plugins;

use const Mvc5\RENDER;

trait Render
{
    /**
     * @param string|mixed $template
     * @param array $vars
     * @return string
     */
    protected function render($template, array $vars = []) : string
    {
        return $this->call(RENDER, [$template, $vars]);
    }
}
