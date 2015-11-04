<?php
/**
 *
 */

namespace Mvc5\Service\Config\Factory;

use Mvc5\Service\Config\Child\Base;
use Mvc5\Service\Resolver\Resolvable;

class Factory
    implements Resolvable, ServiceFactory
{
    /**
     *
     */
    use Base;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->config = [
            self::NAME   => $name,
            self::PARENT => self::FACTORY
        ];
    }
}
