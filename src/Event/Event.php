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
    function name() : string;

    /**
     * @return bool|true
     */
    function stop() : bool;

    /**
     * @return bool
     */
    function stopped() : bool;
}
