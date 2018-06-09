<?php
/**
 *
 */

namespace Mvc5\Config;

use function count;
use function current;
use function key;
use function next;
use function reset;

trait Iterator
{
    /**
     * @return int
     */
    function count() : int
    {
        return count($this->config);
    }

    /**
     * @return mixed
     */
    function current()
    {
        return $this->config instanceof \Iterator ? $this->config->current() : current($this->config);
    }

    /**
     * @return int|string|null
     */
    function key()
    {
        return $this->config instanceof \Iterator ? $this->config->key() : key($this->config);
    }

    /**
     *
     */
    function next() : void
    {
        $this->config instanceof \Iterator ? $this->config->next() : next($this->config);
    }

    /**
     *
     */
    function rewind() : void
    {
        $this->config instanceof \Iterator ? $this->config->rewind() : reset($this->config);
    }

    /**
     * @return bool
     */
    function valid() : bool
    {
        return $this->config instanceof \Iterator ? $this->config->valid() : null !== key($this->config);
    }
}
