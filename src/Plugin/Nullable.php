<?php
/**
 *
 */

namespace Mvc5\Plugin;

final class Nullable
    extends Call
{
    /**
     * @param string|mixed $value
     */
    function __construct($value)
    {
        parent::__construct([$this, '__invoke'], [$value]);
    }

    /**
     * @param \Closure|Nothing|mixed $value
     * @return mixed|null
     */
    function __invoke($value)
    {
        return $value instanceof Nothing ? null : $value;
    }
}
