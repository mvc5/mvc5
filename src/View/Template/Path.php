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
     * @param array|\ArrayAccess|null $config
     * @return array|\ArrayAccess|null
     */
    function paths($config = null)
    {
        return null !== $config ? $this->path = $config : $this->path;
    }
}
