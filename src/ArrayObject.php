<?php

namespace Mvc5;

class ArrayObject
    implements Config\Configuration
{
    /**
     *
     */
    use Config\ArrayModel;
    use Config\Config;

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
