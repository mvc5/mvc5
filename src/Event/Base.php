<?php
/**
 *
 */

namespace Mvc5\Event;

trait Base
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
    public function event()
    {
        return $this->event ? : (defined('static::EVENT') ? constant('static::EVENT') : static::class);
    }

    /**
     *
     */
    public function stop()
    {
        $this->stopped = true;
    }

    /**
     * @return bool
     */
    public function stopped()
    {
        return $this->stopped;
    }
}
