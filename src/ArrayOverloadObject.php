<?php

namespace Mvc5;

class ArrayOverloadObject
    implements Config\Configuration
{
    /**
     *
     */
    use Config\ArrayModel;
    use Config\Overload;

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
