<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;

trait Render
{
    /**
     * @param array|callable|object|string $name
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    protected abstract function call($name, array $args = [], callable $callback = null);

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
