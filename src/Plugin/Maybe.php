<?php
/**
 *
 */

namespace Mvc5\Plugin;

final class Maybe
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
     * @param \Closure|mixed $value
     * @return Nothing|mixed
     */
    function __invoke($value)
    {
        return $value ?? new Nothing;
    }
}
