<?php
/**
 *
 */

namespace Mvc5\Route\Definition\Url;

use Mvc5\Route\Definition\Definition;

interface Create
{
    /**
     * @param array|Definition $definition
     * @return Definition
     */
    function __invoke($definition);
}
