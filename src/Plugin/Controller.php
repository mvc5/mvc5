<?php
/**
 *
 */

namespace Mvc5\Plugin;

use const Mvc5\{ ARGS, CALLS, CONTROLLER, MERGE, NAME, PARENT };

final class Controller
    implements Gem\Child
{
    /**
     *
     */
    use Config\Child;

    /**
     * @param string|null $name
     * @param array $args
     * @param array $calls
     */
    function __construct(string $name = null, array $args = [], array $calls = [])
    {
        $this->config = [
            ARGS   => $args,
            CALLS  => $calls,
            MERGE  => true,
            NAME   => $name,
            PARENT => CONTROLLER
        ];
    }
}
