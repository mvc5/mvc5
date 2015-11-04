<?php
/**
 *
 */

namespace Mvc5\Route\Definition\Build;

use Mvc5\Route\Definition\Definition;
use Mvc5\Route\Definition\RouteDefinition;
use RuntimeException;

trait Base
{
    /**
     *
     */
    use Params;
    use Regex;
    use Tokens;

    /**
     * @param array|Definition $definition
     * @param bool $compile
     * @param bool $recursive
     * @return Definition
     */
    protected function build($definition, $compile = true, $recursive = false)
    {
        if (!isset($definition[Definition::ROUTE])) {
            throw new RuntimeException('Route not specified');
        }

        !isset($definition[Definition::CONSTRAINTS]) && $definition[Definition::CONSTRAINTS] = [];

        !isset($definition[Definition::TOKENS]) && $definition[Definition::TOKENS]
            = $this->tokens($definition[Definition::ROUTE]);

        $compile && !isset($definition[Definition::REGEX]) && $definition[Definition::REGEX]
            = $this->regex($definition[Definition::TOKENS], $definition[Definition::CONSTRAINTS]);

        !isset($definition[Definition::PARAM_MAP]) && $definition[Definition::PARAM_MAP]
            = $this->params($definition[Definition::TOKENS]);

        $recursive && isset($definition[Definition::CHILDREN]) && $definition[Definition::CHILDREN]
            = $this->children($definition[Definition::CHILDREN], $compile, $recursive);

        return $definition;
    }

    /**
     * @param array $definitions
     * @param bool $compile
     * @param bool $recursive
     * @return array
     */
    protected function children(array $definitions, $compile = true, $recursive = true)
    {
        foreach($definitions as $name => $definition) {
            $definitions[$name] = $this->definition($definition, $compile, $recursive);
        }

        return $definitions;
    }

    /**
     * @param array|Definition $definition
     * @return Definition
     */
    protected function create($definition)
    {
        if ($definition instanceof Definition) {
            return $definition;
        }

        if (isset($definition[Definition::CLASS_NAME])) {
            return new $definition[Definition::CLASS_NAME]($definition);
        }

        return new RouteDefinition($definition);
    }

    /**
     * @param array|Definition $definition
     * @param bool $compile
     * @param bool $recursive
     * @return Definition
     */
    protected function definition($definition, $compile = true, $recursive = false)
    {
        return $this->create($this->build($definition, $compile, $recursive));
    }
}
