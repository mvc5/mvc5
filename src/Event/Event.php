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
     * @return void
     */
    function stop();

    /**
     * @return bool
     */
    function stopped();
}
