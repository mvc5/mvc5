<?php
/**
 *
 */

namespace Mvc5\Route\Definition\Add;

use Mvc5\Route\Definition\Build\Base;
use Mvc5\Route\Definition\Definition;
use RuntimeException;

class Child
    implements AddChild
{
    /**
     *
     */
    use Base;

    /**
     * @param Definition $parent
     * @param array|Definition $definition
     * @param array $path
     * @param bool $start
     * @return Definition
     * @throws RuntimeException
     */
    public function __invoke(Definition $parent, $definition, array $path, $start = false)
    {
        if ($root = $parent->child($path[0])) {
            return $this($root, $definition, array_slice($path, 1));
        }

        if (isset($path[1])) {
            throw new RuntimeException('Parent definition not found: ' . $definition[Definition::NAME]);
        }

        $definition[Definition::NAME] = $path[0];

        $start && empty($definition[Definition::ROUTE]) && isset($definition[Definition::NAME])
        && $definition[Definition::ROUTE] = $definition[Definition::NAME];

        !$start && empty($definition[Definition::ROUTE])
        && $definition[Definition::ROUTE] = '/' . $path[0];

        $definition = $this->definition($definition);

        $parent->add($path[0], $definition);

        return $definition;
    }
}
