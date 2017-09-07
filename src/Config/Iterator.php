<?php
/**
 *
 */

namespace Mvc5\Config;

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
    function next()
    {
        $this->config instanceof \Iterator ? $this->config->next() : next($this->config);
    }

    /**
     *
     */
    function rewind()
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
