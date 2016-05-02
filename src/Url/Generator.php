<?php
/**
 *
 */

namespace Mvc5\Url;

use Mvc5\Arg;
use Mvc5\Route\Definition;
use Mvc5\Route\Definition\Assemble;
use Mvc5\Route\Definition\Build;
use Mvc5\Route\Definition\Compile;

class Generator
{
    /**
     *
     */
    use Assemble;
    use Build;
    use Compile;

    /**
     * @var array|Definition
     */
    protected $definition;

    /**
     * @var array
     */
    protected $options = [
        Arg::HOSTNAME => null,
        Arg::PORT     => null,
        Arg::SCHEME   => null
    ];

    /**
     * @param array|Definition $definition
     * @param array $options
     */
    function __construct($definition = [], array $options = [])
    {
        $this->definition = $definition;

        $options && $this->options = $options + $this->options;
    }

    /**
     * @param Definition $parent
     * @param $name
     * @return Definition
     */
    protected function child(Definition $parent, $name)
    {
        return $this->merge($parent, clone $this->url($parent->child($name)));
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
     * @param array|string $name
     * @param array $args
     * @param array $options
     * @param string $path
     * @param Definition $parent
     * @return string|void
     */
    protected function generate($name, array $args = [], array $options = [], $path = '', Definition $parent = null)
    {
        $name = is_array($name) ? $name : explode(Arg::SEPARATOR, $name);

        $definition = $parent ? $this->child($parent, $name[0]) : $this->url($this->config($name[0]));

        $path .= $this->compile($definition->tokens(), $args, $definition->defaults());

        array_shift($name);

        if ($name) {
            return $this->generate($name, $args, $options, $path, $definition);
        }

        if ($args && $definition->wildcard()) {
            $params = array_diff_key($args, $definition->constraints());

            $params && $path = rtrim($path, Arg::SEPARATOR);

            foreach($params as $key => $value) {
                null !== $value && $path .= Arg::SEPARATOR . $key . Arg::SEPARATOR . $value;
            }
        }

        return $this->assemble(
            $definition->scheme(), $definition->hostname(), $definition->port(), $path, $this->options($options)
        );
    }

    /**
     * @param Definition $parent
     * @param Definition $child
     * @return Definition
     */
    protected function merge(Definition $parent, Definition $child)
    {
        !$child->scheme() && $parent->scheme()
            && $child[Arg::SCHEME] = $parent->scheme();

        !$child->hostname() && $parent->hostname()
            && $child[Arg::HOSTNAME] = $parent->hostname();

        !$child->port() && $parent->port()
            && $child[Arg::PORT] = $parent->port();

        return $child;
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
     * @param array $options
     * @return array
     */
    protected function options(array $options = [])
    {
        return $options + $this->options;
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
     * @param null|string $name
     * @param array $args
     * @param array $options
     * @return string
     */
    function __invoke($name = null, array $args = [], array $options = [])
    {
        return rtrim($this->generate($this->name($name), $args, $options), Arg::SEPARATOR) ?: Arg::SEPARATOR;
    }
}
