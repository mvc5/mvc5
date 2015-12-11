<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use Mvc5\Arg;
use Mvc5\Route\Definition;
use RuntimeException;

trait Build
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
     * @return array|Definition
     */
    protected function definition($definition, $compile = true, $recursive = false)
    {
        if (!isset($definition[Arg::ROUTE])) {
            throw new RuntimeException('Route not specified');
        }

        !isset($definition[Arg::CONSTRAINTS]) && $definition[Arg::CONSTRAINTS] = [];

        !isset($definition[Arg::TOKENS]) && $definition[Arg::TOKENS]
            = $this->tokens($definition[Arg::ROUTE]);

        $compile && !isset($definition[Arg::REGEX]) && $definition[Arg::REGEX]
            = $this->regex($definition[Arg::TOKENS], $definition[Arg::CONSTRAINTS]);

        !isset($definition[Arg::PARAM_MAP]) && $definition[Arg::PARAM_MAP]
            = $this->params($definition[Arg::TOKENS]);

        $recursive && isset($definition[Arg::CHILDREN]) && $definition[Arg::CHILDREN]
            = $this->children($definition[Arg::CHILDREN], $compile, $recursive);

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
            $definitions[$name] = $this->build($definition, $compile, $recursive);
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

        if (isset($definition[Arg::CLASS_NAME])) {
            return new $definition[Arg::CLASS_NAME]($definition);
        }

        return new Config($definition);
    }

    /**
     * @param array|Definition $definition
     * @param bool $compile
     * @param bool $recursive
     * @return Definition
     */
    protected function build($definition, $compile = true, $recursive = false)
    {
        return $this->create($this->definition($definition, $compile, $recursive));
    }
}
