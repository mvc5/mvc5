<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Arg;
use Mvc5\Event\Generator as Base;

trait Generator
{
    /**
     *
     */
    use Base;

    /**
     * @var array|\Traversable
     */
    protected $events = [];

    /**
     * @param array|\ArrayAccess|null|\Traversable $config
     * @return array|\ArrayAccess|null|\Traversable
     */
    public function events($config = null)
    {
        return null !== $config ? $this->events = $config : $this->events;
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
