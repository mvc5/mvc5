<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;

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
            Arg::ARGS   => $args,
            Arg::NAME   => $name,
            Arg::PARENT => $parent
        ];
    }
}
