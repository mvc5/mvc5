<?php
/**
 *
 */

namespace Mvc5\Service\Manager;

trait Alias
{
    /**
     * @var array|\ArrayAccess
     */
    protected $alias = [];

    /**
     * @param string $alias
     * @return string
     */
    public function alias($alias)
    {
        return isset($this->alias[$alias]) ? $this->alias[$alias] : null;
    }

    /**
     * @param array|\ArrayAccess $alias
     */
    public function aliases($alias)
    {
        $this->alias = $alias;
    }
}
