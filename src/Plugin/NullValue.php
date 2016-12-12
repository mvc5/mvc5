<?php
/**
 *
 */

namespace Mvc5\Plugin;

class NullValue
    extends Value
{
    /**
     *
     */
    function __construct()
    {
        parent::__construct(null);
    }
}
