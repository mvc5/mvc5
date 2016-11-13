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
    protected $path = [];

    /**
     * @param string $name
     * @return string
     */
    protected function path($name)
    {
        return isset($this->path[$name]) ? $this->path[$name] : null;
    }

    /**
     * @param array|\ArrayAccess|null $paths
     * @return array|\ArrayAccess|null
     */
    function paths($paths = null)
    {
        return null !== $paths ? $this->path = $paths : $this->path;
    }
}
