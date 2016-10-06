<?php
/**
 *
 */

namespace Mvc5\Event;

interface Event
{
    /**
     * @return string
     */
    function event();

    /**
     * @return bool|true
     */
    function stop();

    /**
     * @return bool
     */
    function stopped();
}
