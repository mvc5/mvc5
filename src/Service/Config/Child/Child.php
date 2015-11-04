<?php
/**
 *
 */

namespace Mvc5\Service\Config\Child;

use Mvc5\Service\Resolver\Resolvable;

class Child
    implements ChildService, Resolvable
{
    /**
     *
     */
    use Base;

    /**
     * @param string $name
     * @param string $parent
     * @param array $args
     */
    public function __construct($name, $parent, array $args = [])
    {
        $this->config = [
            self::ARGS   => $args,
            self::NAME   => $name,
            self::PARENT => $parent
        ];
    }
}
