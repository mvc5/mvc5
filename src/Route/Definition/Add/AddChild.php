<?php
/**
 *
 */

namespace Mvc5\Route\Definition\Add;

use Mvc5\Route\Definition\Definition;
use RuntimeException;

interface AddChild
{
    /**
     * @param Definition $parent
     * @param array|Definition $definition
     * @param array $path
     * @param bool $start
     * @return Definition
     * @throws RuntimeException
     */
    function __invoke(Definition $parent, $definition, array $path, $start = false);
}
