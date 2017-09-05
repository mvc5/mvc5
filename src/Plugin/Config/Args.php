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
    protected $args = [];

    /**
     * @param array $args
     */
    function __construct(array $args)
    {
        $this->args = $args;
    }

    /**
     * @return array
     */
    function args() : array
    {
        return $this->args;
    }
}
