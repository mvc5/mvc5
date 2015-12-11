<?php
/**
 *
 */

namespace Mvc5;

interface Service
{
    /**
     * @param Service\Manager|Service\Service|null $service
     * @return Service\Manager|Service\Service|null
     */
    function service(Service\Service $service = null);
}
