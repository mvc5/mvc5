<?php
/**
 *
 */

namespace Mvc5\Session;

interface SessionContainer
    extends Session
{
    /**
     * @return string
     */
    function label() : string;
}
