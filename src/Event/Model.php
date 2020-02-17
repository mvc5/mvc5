<?php
/**
 *
 */

namespace Mvc5\Event;

use function constant;
use function defined;

trait Model
{
    /**
     * @var string|null
     */
    protected ?string $event = null;

    /**
     * @var bool|false
     */
    protected bool $stopped = false;

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
