<?php
/**
 *
 */

namespace Mvc5\Service\Resolver\Event;

use Mvc5\Event\Event;

interface Creator
{
    /**
     * @param string $service
     * @return Dispatch|Event
     */
    function __invoke($service);
}
