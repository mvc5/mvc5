<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Arg;
use Mvc5\Event\Event;
use Mvc5\Event\Generator as Base;

trait Generator
{
    /**
     *
     */
    use Base;

    /**
     * @var array|\ArrayAccess|\Traversable
     */
    protected $events = [];

    /**
     * @param array|object|string|\Traversable $event
     * @param array $args
     * @param callable $callback
     * @return mixed|null
     */
    protected function event($event, array $args = [], callable $callback = null)
    {
        return $this->generate($event, $args, $callback ?? $this);
    }

    /**
     * @param array|\ArrayAccess|null|\Traversable $config
     * @return array|\ArrayAccess|null|\Traversable
     */
    public function events($config = null)
    {
        return null !== $config ? $this->events = $config : $this->events;
    }

    /**
     * @param $plugin
     * @param callable $callback
     * @return callable|null
     */
    protected function listener($plugin, callable $callback = null)
    {
        return !$plugin instanceof Event ? $plugin : function(array $args = []) use ($plugin, $callback) {
            return $this->event($plugin, $args, $callback);
        };
    }

    /**
     * @param string $name
     * @return array|\Traversable|null
     */
    protected function listeners($name)
    {
        return $this->events[$name] ?? $this->signal(new Exception, [Arg::PLUGIN => $name]);
    }
}
