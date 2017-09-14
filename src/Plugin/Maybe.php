<?php
/**
 *
 */

namespace Mvc5\Plugin;

final class Maybe
    extends Filter
{

    /**
     * @param mixed $value
     */
    function __construct($value)
    {
        parent::__construct($value, [[static::class, 'nothing']]);
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    static function nothing($value)
    {
        return $value ?? new Nothing;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    static function nullable($value)
    {
        return $value instanceof Nothing ? null : $value;
    }
}
