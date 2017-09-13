<?php
/**
 *
 */

namespace Mvc5\Plugin;

final class NullValue
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
