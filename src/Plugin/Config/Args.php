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
    public function __construct($args)
    {
        $this->args = $args;
    }

    /**
     * @return array
     */
    public function args()
    {
        return $this->args;
    }
}
