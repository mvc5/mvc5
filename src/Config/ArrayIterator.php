<?php
/**
 *
 */

namespace Mvc5\Config;

use function current;
use function key;
use function next;
use function reset;

trait ArrayIterator
{
    /**
     * @var array
     */
    protected array $config = [];

    /**
     * @return mixed
     */
    function current() : mixed
    {
        return current($this->config);
    }

    /**
     * @return int|string|null
     */
    function key() : int|string|null
    {
        return key($this->config);
    }

    /**
     *
     */
    function next() : void
    {
        next($this->config);
    }

    /**
     *
     */
    function rewind() : void
    {
        reset($this->config);
    }

    /**
     * @return bool
     */
    function valid() : bool
    {
        return null !== key($this->config);
    }
}
