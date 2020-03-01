<?php
/**
 *
 */

namespace Mvc5\Config;

trait ArrayModel
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
     * @param array|mixed $config
     */
    function __construct($config = [])
    {
        $this->config = (array) $config;
    }
}
