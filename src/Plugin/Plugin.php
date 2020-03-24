<?php
/**
 *
 */

namespace Mvc5\Plugin;

use const Mvc5\{ ARGS, CALLS, ITEM, NAME, PARAM, MERGE };

class Plugin
    implements Gem\Plugin
{
    /**
     *
     */
    use Config\Plugin;

    /**
     * @param string|null $name
     * @param array $args
     * @param array $calls
     * @param string|null $param
     * @param bool|false $merge
     */
    function __construct(string $name = null, array $args = [], array $calls = [], string $param = null, bool $merge = false)
    {
        $this->config = [
            ARGS  => $args,
            CALLS => $calls,
            NAME  => $name,
            PARAM => $param ?? ITEM,
            MERGE => $merge
        ];
    }
}
