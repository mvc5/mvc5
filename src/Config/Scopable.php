<?php
/**
 *
 */

namespace Mvc5\Config;

interface Scopable
{
    /**
     * @param object $object
     * @return Scopable
     */
    function withScope($object) : Scopable;
}
