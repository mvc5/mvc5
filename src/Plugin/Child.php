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
     * @param string $name
     * @param string $parent
     * @param array $args
     */
    public function __construct($name, $parent, array $args = [])
    {
        $this->config = [
            Arg::ARGS   => $args,
            Arg::NAME   => $name,
            Arg::PARENT => $parent
        ];
    }
}
