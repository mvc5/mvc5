<?php
/**
 *
 */

namespace Mvc5\Config;

trait ArrayObject
{
    /**
     *
     */
    use ArrayIterator;
    use Count;

    /**
     * @var array
     */
    protected array $config = [];

    /**
     * @param array $config
     */
    function __construct(array $config = [])
    {
        $this->config = $config;
    }
}
