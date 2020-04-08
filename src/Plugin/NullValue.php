<?php
/**
 *
 */

namespace Mvc5\Plugin;

final class NullValue
    implements Gem\Value
{
    /**
     * @return null
     */
    function config()
    {
        return null;
    }
}
