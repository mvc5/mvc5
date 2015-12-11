<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;

class Hydrator
    implements Gem\Plugin
{
    /**
     *
     */
    use Config\Hydrator;

    /**
     * @param string $name
     * @param array $calls
     * @param null|string $param
     */
    public function __construct($name, array $calls, $param = Arg::ITEM)
    {
        $this->config = [
            Arg::CALLS => $calls,
            Arg::NAME  => $name,
            Arg::PARAM => $param
        ];
    }
}
