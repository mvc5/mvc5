<?php
/**
 *
 */

namespace Mvc5\Service\Provider;

use Mvc5\Service\Resolver\Resolvable;
use RuntimeException;

class Resolver
    implements DefaultResolver
{
    /**
     * @param Resolvable $service
     * @return Resolvable
     */
    public function __invoke(Resolvable $service)
    {
        throw new RuntimeException('Unresolvable service configuration: ' . get_class($service));
    }
}
