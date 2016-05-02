<?php
/**
 *
 */

namespace Mvc5\Plugin\Config;

trait Args
{
    /**
     * @var array
     */
    protected $args;

    /**
     * @param $args
     */
    function __construct($args)
    {
        $this->args = $args;
    }

    /**
     * @return array
     */
    function args()
    {
        return $this->args;
    }
}
