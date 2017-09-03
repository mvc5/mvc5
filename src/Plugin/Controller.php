<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;

class Controller
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
            Arg::ARGS   => $args,
            Arg::CALLS  => $calls,
            Arg::MERGE  => true,
            Arg::NAME   => $name,
            Arg::PARENT => Arg::CONTROLLER
        ];
    }
}
