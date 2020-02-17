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
    protected string $name;

    /**
     * @param string $name
     */
    function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    function name() : string
    {
        return $this->name;
    }
}
