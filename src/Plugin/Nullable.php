<?php
/**
 *
 */

namespace Mvc5\Plugin;

final class Nullable
    extends Call
{
    /**
     * @var mixed|null
     */
    protected $default;

    /**
     * @param mixed|null $value
     * @param mixed|null $default
     */
    function __construct($value = null, $default = null)
    {
        parent::__construct([$this, '__invoke'], [$value]);

        $this->default = $default;
    }

    /**
     * @param Nothing|mixed|null $value
     * @return mixed|null
     */
    function __invoke($value = null)
    {
        return $value instanceof Nothing ? $this->default : $value;
    }
}
