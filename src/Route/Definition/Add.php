<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use Mvc5\Arg;
use Mvc5\Route\Definition;
use RuntimeException;

class Add
{
    /**
     *
     */
    use Build;

    /**
     * @param Definition $parent
     * @param array|Definition $definition
     * @param array $path
     * @param bool $start
     * @return array|Definition
     * @throws RuntimeException
     */
    function __invoke(Definition $parent, $definition, array $path, $start = false)
    {
        if ($root = $parent->child($path[0])) {
            return $this($root, $definition, array_slice($path, 1));
        }

        if (isset($path[1])) {
            throw new RuntimeException('Parent definition not found: ' . $definition[Arg::NAME]);
        }

        $definition[Arg::NAME] = $path[0];

        $start && empty($definition[Arg::ROUTE]) && isset($definition[Arg::NAME])
            && $definition[Arg::ROUTE] = $definition[Arg::NAME];

        !$start && empty($definition[Arg::ROUTE])
            && $definition[Arg::ROUTE] = Arg::SEPARATOR . $path[0];

        $definition = $this->definition($definition);

        $parent->add($path[0], $definition);

        return $definition;
    }
}
