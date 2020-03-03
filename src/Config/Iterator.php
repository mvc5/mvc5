<?php
/**
 *
 */

namespace Mvc5\Config;

trait Iterator
{
    /**
     * @var Model
     */
    protected Model $config;

    /**
     * @return mixed
     */
    function current()
    {
        return $this->config->current();
    }

    /**
     * @return int|string|null
     */
    function key()
    {
        return $this->config->key();
    }

    /**
     *
     */
    function next() : void
    {
        $this->config->next();
    }

    /**
     *
     */
    function rewind() : void
    {
        $this->config->rewind();
    }

    /**
     * @return bool
     */
    function valid() : bool
    {
        return $this->config->valid();
    }
}
