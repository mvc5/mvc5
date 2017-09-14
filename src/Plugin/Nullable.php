<?php
/**
 *
 */

namespace Mvc5\Plugin;

final class Nullable
    extends Filter
{

    /**
     * @param mixed $value
     */
    function __construct($value)
    {
        parent::__construct($value, [[Maybe::class, 'nullable']]);
    }
}
