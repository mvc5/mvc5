<?php
/**
 *
 */

namespace Mvc5\Plugin;

use const Mvc5\{ FACTORY, NAME, PARENT };

final class Factory
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
            NAME   => $name,
            PARENT => FACTORY
        ];
    }
}
