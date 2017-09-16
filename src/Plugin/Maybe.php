<?php
/**
 *
 */

namespace Mvc5\Plugin;

final class Maybe
    extends Call
{
    /**
     * @var mixed|null
     */
    protected $default;

    /**
     * @param null $value
     * @param mixed|null $default
     */
    function __construct($value = null, $default = null)
    {
        parent::__construct([$this, '__invoke'], [$value]);

        $this->default = $default;
    }

    /**
     * @param mixed|null $value
     * @return Nothing|mixed
     */
    function __invoke($value = null)
    {
        return $value ?? $this->default ?? new Nothing;
    }
}
