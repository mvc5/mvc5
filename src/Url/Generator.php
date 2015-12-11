<?php
/**
 *
 */

namespace Mvc5\Url;

use Mvc5\Arg;
use Mvc5\Route\Definition;
use Mvc5\Route\Definition\Build;
use Mvc5\Route\Definition\Compile;
use RuntimeException;

class Generator
{
    /**
     *
     */
    use Build;
    use Compile;

    /**
     * @var array|Definition
     */
    protected $definition;

    /**
     * @param array|Definition $definition
     */
    public function __construct($definition)
    {
        $this->definition = $definition;
    }

    /**
     * @param $name
     * @return array|Definition
     */
    protected function config($name)
    {
        return $name === $this->definition[Arg::NAME] ? $this->definition : $this->definition->child($name);
    }

    /**
     * @param array|Definition $definition
     * @return Definition|null
     */
    protected function url($definition)
    {
        return $definition instanceof Definition && isset($definition[Arg::REGEX]) ? $definition
            : $this->build($definition, false);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function name($name)
    {
        return $name === $this->definition[Arg::NAME] ? $name : $this->definition[Arg::NAME] . Arg::SEPARATOR . $name;
    }

    /**
     * @param array|string $name
     * @param array $args
     * @param Definition $definition
     * @return string|void
     * @throws RuntimeException
     */
    protected function generate($name, array $args = [], Definition $definition = null)
    {
        $name = is_array($name) ? $name : explode(Arg::SEPARATOR, $name);

        $definition = $definition ? $this->url($definition->child($name[0])) : $this->url($this->config($name[0]));

        if (!$definition) {
            throw new RuntimeException('Route definition not found: ' . $name[0]);
        }

        array_shift($name);

        $url = $this->compile($definition->tokens(), $args, $definition->defaults());

        $name && $url .= $this->generate($name, $args, $definition);

        if ($args && $definition->wildcard()) {
            foreach(array_diff_key($args, $definition->constraints()) as $key => $value) {
                null !== $value && $url .= Arg::SEPARATOR . $key . Arg::SEPARATOR . $value;
            }
        }

        return $url;
    }

    /**
     * @param null|string $name
     * @param array $args
     * @return string
     */
    public function __invoke($name = null, array $args = [])
    {
        return rtrim($this->generate($this->name($name), $args), Arg::SEPARATOR) ?: Arg::SEPARATOR;
    }
}
