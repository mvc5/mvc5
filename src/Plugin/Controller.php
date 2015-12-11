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
     * @param string $name
     * @param array $args
     * @param array $calls
     */
    public function __construct($name, array $args = [], array $calls = [])
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
