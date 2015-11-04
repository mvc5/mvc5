<?php
/**
 *
 */

namespace Mvc5\Route\Generator;

use Mvc5\Route\Definition\Build\Compile;
use Mvc5\Route\Definition\Definition;
use RuntimeException;

class Generator
    implements RouteGenerator
{
    /**
     *
     */
    use Compile;

    /**
     * @var callable
     */
    protected $callback;

    /**
     * @var array|Definition
     */
    protected $definition;

    /**
     * @param array|Definition $definition
     * @param callable $callback
     */
    public function __construct($definition, callable $callback = null)
    {
        $this->callback   = $callback;
        $this->definition = $definition;
    }

    /**
     * @param array|string $name
     * @param array $args
     * @param Definition $definition
     * @return string|void
     * @throws RuntimeException
     */
    protected function build($name, array $args = [], Definition $definition = null)
    {
        $name = is_array($name) ? $name : explode('/', $name);

        $definition = $definition ? $this->create($definition->child($name[0])) : $this->create($this->config($name[0]));

        if (!$definition) {
            throw new RuntimeException('Route generator definition not found: ' . $name[0]);
        }

        array_shift($name);

        $url = $this->compile($definition->tokens(), $args, $definition->defaults());

        $name && $url .= $this->build($name, $args, $definition);

        if ($args && $definition->wildcard()) {
            foreach(array_diff_key($args, $definition->constraints()) as $key => $value) {
                null !== $value && $url .= '/' . $key . '/' . $value;
            }
        }

        return $url;
    }

    /**
     * @param $name
     * @return Definition
     */
    protected function config($name)
    {
        return $name === $this->definition[Definition::NAME] ? $this->definition : $this->definition->child($name);
    }

    /**
     * @param array|Definition $definition
     * @return Definition|null
     */
    protected function create($definition)
    {
        return $definition instanceof Definition && !empty($definition[Definition::REGEX]) ? $definition
            : ($this->callback ? call_user_func($this->callback, $definition) : null);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function name($name)
    {
        return $name === $this->definition[Definition::NAME] ? $name : $this->definition[Definition::NAME] . '/' . $name;
    }

    /**
     * @param string $name
     * @param array $args
     * @return string
     */
    public function url($name, array $args = [])
    {
        return rtrim($this->build($this->name($name), $args), '/') ?: '/';
    }
}
