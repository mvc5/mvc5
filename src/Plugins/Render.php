<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;

trait Render
{
    /**
     * @param mixed|string $template
     * @param array $vars
     * @return string
     */
    protected function render($template, array $vars = [])
    {
        return $this->call(Arg::RENDER, [$template, $vars]);
    }
}
