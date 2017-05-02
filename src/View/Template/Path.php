<?php
/**
 *
 */

namespace Mvc5\View\Template;

trait Path
{
    /**
     * @var array|\ArrayAccess
     */
    protected $paths = [];

    /**
     * @param string $name
     * @return string
     */
    protected function path($name)
    {
        return isset($this->paths[$name]) ? $this->paths[$name] : null;
    }
}
