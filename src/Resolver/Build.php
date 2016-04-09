<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Service\Container;
use Mvc5\Service\Manager;
use ReflectionClass;
use RuntimeException;

trait Build
{
    /**
     * @param $args
     * @return array|callable|null|object|string
     */
    protected abstract function args($args);

    /**
     * @param array $config
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function build(array $config, array $args = [], callable $callback = null)
    {
        return $this->compose($this->create(array_shift($config), $args, $callback), $config, $args, $callback);
    }

    /**
     * @param $name
     * @param array $args
     * @param callable|null $callback
     * @return callable|object
     */
    protected function callback($name, array $args = [], callable $callback = null)
    {
        return $callback && !class_exists($name) ? $callback($name) : $this->make($name, $args);
    }

    /**
     * @param array $config
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function combine(array $config, array $args = [], callable $callback = null)
    {
        return $this->compose(
            $this->first(array_shift($config), $config, $args, $callback), $config, $args, $callback
        );
    }

    /**
     * @param $plugin
     * @param array $config
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function compose($plugin, array $config = [], array $args = [], callable $callback = null)
    {
        return !$config ? $plugin : $this->compose(
            $this->composite($plugin, array_shift($config), $args, $callback), $config, $args, $callback
        );
    }

    /**
     * @param $plugin
     * @param $name
     * @param array $args
     * @param callable|null $callback
     * @return array|callable|null|object|string
     */
    protected function composite($plugin, $name, array $args = [], callable $callback = null)
    {
        if ($plugin instanceof Manager) {
            return $plugin->plugin($name, $args, $callback);
        }

        if ($plugin instanceof Container) {
            return $this->plugin($plugin[$name], $args, $callback);
        }

        return $this->resolve($plugin[$name], $args);
    }

    /**
     * @param $name
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function create($name, array $args = [], callable $callback = null)
    {
        return $this->unique($name, $this->configured($name), $args, $callback);
    }

    /**
     * @param string $name
     * @return array|callable|null|object|string
     */
    public abstract function configured($name);

    /**
     * @param $name
     * @param array $config
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function first($name, array $config, array $args = [], callable $callback = null)
    {
        return !$config ? $this->callback($name, $args, $callback) : $this->create($name, $args, $callback);
    }

    /**
     * @param string $name
     * @param array $args
     * @return callable|object
     */
    protected function make($name, array $args = [])
    {
        $class = new ReflectionClass($name);

        if (!$class->hasMethod('__construct')) {
            return $class->newInstanceWithoutConstructor();
        }

        if ($args && !is_string(key($args))) {
            return $class->newInstanceArgs($this->args($args));
        }

        $matched = [];
        $params  = $class->getConstructor()->getParameters();

        foreach($params as $param) {
            if (isset($args[$param->name])) {
                $matched[] = $this->resolve($args[$param->name]);
                continue;
            }

            if ($param->isOptional()) {
                $param->isDefaultValueAvailable() &&
                $matched[] = $param->getDefaultValue();
                continue;
            }

            if (null !== ($hint = $param->getClass()) && null !== $match = $this($hint->name)) {
                $matched[] = $match;
                continue;
            }

            if (null !== $match = $this($param->name)) {
                $matched[] = $match;
                continue;
            }

            throw new RuntimeException('Missing required parameter $' . $param->name . ' for ' . $name);
        }

        return $class->newInstanceArgs($params ? $matched : $this->args($args));
    }

    /**
     * @param string $config
     * @param array $args
     * @param callable|null $callback
     * @return array|callable|null|object|string
     */
    public abstract function plugin($config, array $args = [], callable $callback = null);

    /**
     * @param $config
     * @param array $args
     * @return array|callable|null|object|string
     * @throws RuntimeException
     */
    protected abstract function resolve($config, array $args = []);

    /**
     * @param $name
     * @param $config
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function unique($name, $config, array $args = [], callable $callback = null)
    {
        return ($name !== $config ? $this($config, $args) : null) ?? $this->callback($name, $args, $callback);
    }

    /**
     * @param string $name
     * @param array $args
     * @return array|callable|null|object|string
     */
    public abstract function __invoke($name, array $args = []);
}
