<?php
/**
 *
 */

namespace Mvc5\Service\Manager;

use Closure;
use Mvc5\Service\Config\Configuration;
use Mvc5\Service\Container\Container;
use Mvc5\Service\Resolver\Args;
use Mvc5\Service\Resolver\Resolver;

trait ManageService
{
    /**
     *
     */
    use Alias;
    use Container;
    use Initializer;
    use Resolver;

    /**
     * @param array|callable|Configuration|null|object|string $config
     * @param array $args
     * @param callable $callback
     * @return callable|null|object
     */
    public function create($config, array $args = [], callable $callback = null)
    {
        if (!$config) {
            return $config;
        }

        if (is_string($config)) {
            return $this->create($this->configured($config), $args, $callback ?: $this) ?:
                $this->build(explode(Args::SERVICE_SEPARATOR, $config), $args, $callback);
        }

        if (is_array($config)) {
            return $this->create(array_shift($config), $config, $callback);
        }

        if ($config instanceof Closure) {
            return $this->invoke($config, $args, $callback);
        }

        return $this->resolve($config, $args);
    }

    /**
     * @param string $name
     * @param array $args
     * @param callable $callback
     * @return null|object|callable
     */
    public function get($name, array $args = [], callable $callback = null)
    {
        return $this->service($name) ?: $this->initialize($name, $args, $callback);
    }

    /**
     * @param string $name
     * @param callable $callback
     * @param array $args
     * @return callable|null|object
     */
    public function plugin($name, array $args = [], callable $callback = null)
    {
        return $this->resolve($this->alias($name), $args) ?: $this->create($name, $args, $callback ?: function(){});
    }
}
