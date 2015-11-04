<?php
/**
 *
 */

namespace Mvc5\Service\Config\Manager;

use Mvc5\Service\Config\Child\Base;
use Mvc5\Service\Resolver\Resolvable;

class Manager
    implements Resolvable, ServiceManager
{
    /**
     *
     */
    use Base;

    /**
     * @param string $name
     * @param array $calls
     */
    public function __construct($name, array $calls = [])
    {
        $this->config = [
            self::CALLS  => $calls,
            self::MERGE  => true,
            self::NAME   => $name,
            self::PARENT => self::MANAGER
        ];
    }
}
