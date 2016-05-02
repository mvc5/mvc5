<?php
/**
 *
 */

namespace Mvc5\Plugin\Config;

trait Name
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     */
    function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    function name()
    {
        return $this->name;
    }
}
