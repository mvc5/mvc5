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
     * @param string $param
     * @param bool|false $merge
     */
    function __construct($name = null, array $args = [], array $calls = [], $param = Arg::ITEM, $merge = false)
    {
        $this->config = [
            Arg::ARGS  => $args,
            Arg::CALLS => $calls,
            Arg::NAME  => $name,
            Arg::PARAM => $param ? $param : Arg::ITEM,
            Arg::MERGE => $merge
        ];
    }
}
