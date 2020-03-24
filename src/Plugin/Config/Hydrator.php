<?php
/**
 *
 */

namespace Mvc5\Plugin\Config;

use const Mvc5\{ CALLS, ITEM, NAME, PARAM };

trait Hydrator
{
    /**
     *
     */
    use Plugin;

    /**
     * @param string $name
     * @param array $calls
     * @param string|null $param
     */
    function __construct($name, array $calls, $param = ITEM)
    {
        $this->config = [
            CALLS => $calls,
            NAME  => $name,
            PARAM => $param
        ];
    }
}
