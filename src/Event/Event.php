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
    function name();

    /**
     * @return bool|true
     */
    function stop();

    /**
     * @return bool
     */
    function stopped();
}
