<?php
/**
 *
 */

namespace Mvc5\Resolver;

trait Alias
{
    /**
     * @var array|\ArrayAccess
     */
    protected $alias = [];

    /**
     * @param string $name
     * @return string
     */
    protected function alias($name)
    {
        return isset($this->alias[$name]) ? $this->alias[$name] : null;
    }

    /**
     * @param array|\ArrayAccess|null $config
     * @return array|\ArrayAccess
     */
    public function aliases($config = null)
    {
        return null === $config ? $this->alias : $this->alias = $config;
    }
}
