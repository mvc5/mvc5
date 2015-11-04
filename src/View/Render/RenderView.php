<?php
/**
 *
 */

namespace Mvc5\View\Render;

interface RenderView
{
    /**
     *
     */
    const VIEW = 'View\Render';

    /**
     * @param callable $callable
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null);
}
