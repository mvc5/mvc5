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
    function count()
    {
        /** @var Config $this */
        return count($this->config);
    }

    /**
     * @return mixed
     */
    function current()
    {
        /** @var Config $this */
        return is_array($this->config) ? current($this->config) : $this->config->current();
    }

    /**
     * @return mixed
     */
    function key()
    {
        /** @var Config $this */
        return is_array($this->config) ? key($this->config) : $this->config->key();
    }

    /**
     *
     */
    function next()
    {
        /** @var Config $this */
        is_array($this->config) ? next($this->config) : $this->config->next();
    }

    /**
     *
     */
    function rewind()
    {
        /** @var Config $this */
        is_array($this->config) ? reset($this->config) : $this->config->rewind();
    }

    /**
     * @return bool
     */
    function valid()
    {
        /** @var Config $this */
        return is_array($this->config) ? null !== $this->key() : $this->config->valid();
    }
}
