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
     * @param string|null $name
     */
    function __construct(string $name = null)
    {
        $this->config = [
            Arg::NAME   => $name,
            Arg::PARENT => Arg::FACTORY
        ];
    }
}
