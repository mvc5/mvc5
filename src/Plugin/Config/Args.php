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
     * @return array
     */
    public function args()
    {
        return $this->args;
    }
}
