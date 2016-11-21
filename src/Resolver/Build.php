<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Exception;
use Mvc5\Service\Container;
use Mvc5\Service\Manager;

trait Build
{
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
     * @param $config
     * @param array $args
     * @param callable|null $callback
     * @return callable|object
     */
    protected function callback($name, $config = null, array $args = [], callable $callback = null)
    {
        return $callback && !class_exists($name) ? $callback($name) : (
            $config || !$this->strict() || $this->configured($name) ? $this->make($name, $args) : null
        );
    }

    /**
     * @param array $config
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function combine(array $config, array $args = [], callable $callback = null)
    {
        return $this->compose($this->first(array_shift($config), $config, $args, $callback), $config, $args, $callback);
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
    abstract function configured($name);

    /**
     * @param $name
     * @param array $config
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function first($name, array $config, array $args = [], callable $callback = null)
    {
        return !$config ? $this->callback($name, null, $args, $callback) : $this->create($name, $args, $callback);
    }

    /**
     * @param string $name
     * @param array $args
     * @return callable|object
     */
    protected function make($name, array $args = [])
    {
        $class = new \ReflectionClass($name);

        if (!$class->hasMethod('__construct')) {
            return $class->newInstanceWithoutConstructor();
        }

        if ($args && !is_string(key($args))) {
            return $class->newInstanceArgs($args);
        }

        $matched = [];
        $params  = $class->getConstructor()->getParameters();

        foreach($params as $param) {
            if (isset($args[$param->name])) {
                $matched[] = $args[$param->name];
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

            Exception::runtime('Missing required parameter $' . $param->name . ' for ' . $name);
        }

        return $class->newInstanceArgs($params ? $matched : $args);
    }

    /**
     * @param string $config
     * @param array $args
     * @param callable|null $callback
     * @return array|callable|null|object|string
     */
    abstract function plugin($config, array $args = [], callable $callback = null);

    /**
     * @param $config
     * @param array $args
     * @return array|callable|null|object|string
     */
    protected abstract function resolve($config, array $args = []);

    /**
     * @return bool
     */
    protected abstract function strict();

    /**
     * @param $name
     * @param $config
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function unique($name, $config, array $args = [], callable $callback = null)
    {
        return $config && $name !== $config ?
            $this->plugin($config, $args, $callback, $name) : $this->callback($name, $config, $args, $callback);
    }

    /**
     * @param string $name
     * @param array $args
     * @return array|callable|null|object|string
     */
    abstract function __invoke($name, array $args = []);
}
