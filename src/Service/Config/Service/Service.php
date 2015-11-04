<?php
/**
 *
 */

namespace Mvc5\Service\Config\Service;

use Mvc5\Service\Config\Base;
use Mvc5\Service\Resolver\Resolvable;

class Service
    implements Config, Resolvable
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
            self::CALLS => $calls,
            self::NAME  => $name
        ];
    }
}
