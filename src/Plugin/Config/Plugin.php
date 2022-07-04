<?php
/**
 *
 */

namespace Mvc5\Plugin\Config;

use Mvc5\Config\ArrayObject;
use Mvc5\Config\Readable;

use const Mvc5\{ ARGS, CALLS, MERGE, NAME, PARAM };

trait Plugin
{
    /**
     *
     */
    use ArrayObject;
    use Readable;

    /**
     * @return array
     */
    function args() : array
    {
        return $this[ARGS] ?? [];
    }

    /**
     * @return array
     */
    function calls() : array
    {
        return $this[CALLS] ?? [];
    }

    /**
     * @return bool
     */
    function merge() : bool
    {
        return (bool) $this[MERGE];
    }

    /**
     * @return mixed
     */
    function name()
    {
        return $this[NAME];
    }

    /**
     * @return string|null
     */
    function param() : ?string
    {
        return $this[PARAM];
    }
}
