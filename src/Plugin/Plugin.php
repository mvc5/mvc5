<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;

class Plugin
    implements Gem\Plugin
{
    /**
     *
     */
    use Config\Plugin;

    /**
     * @param string $name
     * @param array $args
     * @param array $calls
     */
    public function __construct($name, array $args = [], array $calls = [])
    {
        $this->config = [
            Arg::ARGS  => $args,
            Arg::CALLS => $calls,
            Arg::NAME  => $name
        ];
    }
}
