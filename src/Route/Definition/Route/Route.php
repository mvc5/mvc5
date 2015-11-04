<?php
/**
 *
 */

namespace Mvc5\Route\Definition\Route;

use Mvc5\Route\Definition\Build\Base;
use Mvc5\Route\Definition\Definition;

class Route
    implements Create
{
    /**
     *
     */
    use Base;

    /**
     * @param array|Definition $definition
     * @param bool $compile
     * @param bool $recursive
     * @return Definition
     */
    public function __invoke($definition, $compile = true, $recursive = false)
    {
        return $this->definition($definition, $compile, $recursive);
    }
}
