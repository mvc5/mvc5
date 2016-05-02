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
    function event()
    {
        return $this->event ?? (defined('static::EVENT') ? constant('static::EVENT') : static::class);
    }

    /**
     *
     */
    function stop()
    {
        $this->stopped = true;
    }

    /**
     * @return bool
     */
    function stopped()
    {
        return $this->stopped;
    }
}
