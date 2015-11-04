<?php
/**
 *
 */

namespace Mvc5\Event\Manager;

use Mvc5\Event\Event;

interface EventManager
{
    /**
     * @param array|Event|string $event
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    function trigger($event, array $args = [], callable $callback = null);
}
