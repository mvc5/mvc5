<?php
/**
 *
 */

namespace Mvc5\Event;

trait Model
{
    /**
     * @var string
     */
    protected $event;

    /**
     * @var bool
     */
    protected $stopped = false;

    /**
     * @return string
     */
    function name() : string
    {
        return $this->event ?? (defined('static::EVENT') ? constant('static::EVENT') : static::class);
    }

    /**
     * @return bool|true
     */
    function stop() : bool
    {
        return $this->stopped = true;
    }

    /**
     * @return bool
     */
    function stopped() : bool
    {
        return $this->stopped;
    }
}
