<?php
/**
 *
 */

namespace Mvc5\Service\Config\ServiceProvider;

use Mvc5\Service\Config\Base;
use Mvc5\Service\Config\ServiceManagerLink\ServiceManagerLink;
use Mvc5\Service\Resolver\Resolvable;

class ServiceProvider
    implements Provider, Resolvable
{
    /**
     *
     */
    use Base;

    /**
     * @param string $name
     * @param array $args
     * @param array $calls
     */
    public function __construct($name, array $args = [], array $calls = [])
    {
        $this->config = [
            self::ARGS  => $args,
            self::CALLS => $calls + [self::PROVIDER => new ServiceManagerLink],
            self::NAME  => $name
        ];
    }
}
