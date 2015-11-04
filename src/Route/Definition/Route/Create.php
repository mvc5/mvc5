<?php
/**
 *
 */

namespace Mvc5\Route\Definition\Route;

use Mvc5\Route\Definition\Definition;

interface Create
{
    /**
     * @param array|Definition $definition
     * @param bool $compile
     * @param bool $recursive
     * @return Definition
     */
    function __invoke($definition, $compile = true, $recursive = false);
}
