<?php
/**
 *
 */

namespace Mvc5\Service\Provider;

use Mvc5\Service\Resolver\Resolvable;

interface DefaultResolver
{
    /**
     * @param Resolvable $service
     * @return Resolvable
     */
    function __invoke(Resolvable $service);
}
