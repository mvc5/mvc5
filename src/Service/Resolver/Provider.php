<?php
/**
 *
 */

namespace Mvc5\Service\Resolver;

use Mvc5\Config\Configuration;
use Mvc5\Event\Event;
use Mvc5\Event\Manager\EventManager;
use Mvc5\Service\Config\Configuration as Config;
use Mvc5\Service\Manager\ServiceManager;
use Mvc5\Service\Provider\ServiceProvider;

trait Provider
{
    /**
     *
     */
    use Resolver;

    /**
     * @var EventManager|ServiceManager|ServiceProvider
     */
    protected $provider;

    /**
     * @return Configuration
     */
    public function config()
    {
        return $this->provider->config();
    }

    /**
     * @param string $name
     * @return array|callable|Config|null|object|string
     */
    public function configured($name)
    {
        return $this->provider->configured($name);
    }

    /**
     * @param array|callable|Configuration|null|object|string $config
     * @param array $args
     * @param callable $callback
     * @return callable|null|object
     */
    public function create($config, array $args = [], callable $callback = null)
    {
        return $this->provider->create($config, $args, $callback);
    }

    /**
     * @param string $name
     * @return null|object|callable
     */
    public function get($name)
    {
        return $this->provider->get($name);
    }

    /**
     * @param string $name
     * @param callable $callback
     * @param array $args
     * @return callable|null|object
     */
    public function plugin($name, array $args = [], callable $callback = null)
    {
        return $this->provider->plugin($name, $args, $callback);
    }

    /**
     * @param EventManager|ServiceManager|ServiceProvider $provider
     */
    public function provider($provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param array|Event|string $event
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    public function trigger($event, array $args = [], callable $callback = null)
    {
        return $this->provider->trigger($event, $args, $callback);
    }
}
