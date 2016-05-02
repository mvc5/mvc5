<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;

class Factory
    implements Gem\Factory
{
    /**
     *
     */
    use Config\Child;

    /**
     * @param string $name
     */
    function __construct($name)
    {
        $this->config = [
            Arg::NAME   => $name,
            Arg::PARENT => Arg::FACTORY
        ];
    }
}
