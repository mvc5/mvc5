<?php
/**
 *
 */

namespace Mvc5\Plugin;

class ScopedCall
    extends Call
{
    /**
     * @param $config
     * @param array $args
     */
    function __construct($config, array $args = [])
    {
        parent::__construct(new Scoped($config), $args);
    }
}
