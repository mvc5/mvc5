<?php
/**
 *
 */

namespace Mvc5\Route;

class Generator
{
    /**
     *
     */
    use Definition\Build;

    /**
     * @param array|Definition $definition
     * @param bool $compile
     * @param bool $recursive
     * @return Definition
     */
    public function __invoke($definition, $compile = true, $recursive = false)
    {
        return $this->build($definition, $compile, $recursive);
    }
}
