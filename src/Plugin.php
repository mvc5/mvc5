<?php
/**
 *
 */

namespace Mvc5;

trait Plugin
{
    /**
     *
     */
    use Service\Plugin;

    /**
     * @param Service\Manager|Service\Service|null $service
     * @return Service\Manager|Service\Service|null
     */
    function service(Service\Service $service = null)
    {
        return null !== $service ? $this->service = $service : $this->service;
    }
}
