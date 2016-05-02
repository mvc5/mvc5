<?php
/**
 *
 */

namespace Mvc5\View\Template;

trait Templates
{
    /**
     * @var array|\ArrayAccess
     */
    protected $templates = [];

    /**
     * @param string $name
     * @return string
     */
    protected function template($name)
    {
        return $this->templates[$name] ?? null;
    }

    /**
     * @param array|\ArrayAccess|null $config
     * @return array|\ArrayAccess|null
     */
    function templates($config = null)
    {
        return null !== $config ? $this->templates = $config : $this->templates;
    }
}
