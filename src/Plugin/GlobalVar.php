<?php
/**
 *
 */

namespace Mvc5\Plugin;

final class GlobalVar
    implements Gem\Value
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
     * @return array|mixed
     */
    function config()
    {
        return $GLOBALS[$this->name] ?? null;
    }
}
