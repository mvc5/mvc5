<?php
/**
 *
 */

namespace Mvc5\Plugin;

use const Mvc5\{ ARGS, NAME, PARENT };

class Child
    implements Gem\Child
{
    /**
     *
     */
    use Config\Child;

    /**
     * @param string|null $name
     * @param string|null $parent
     * @param array $args
     */
    function __construct(string $name = null, string $parent = null, array $args = [])
    {
        $this->config = [
            ARGS   => $args,
            NAME   => $name,
            PARENT => $parent
        ];
    }
}
