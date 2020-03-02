<?php
/**
 *
 */

namespace Mvc5\Config;

use Mvc5\ArrayOverload;

trait ModelOverload
{
    /**
     *
     */
    use ModelObject;

    /**
     * @var Model
     */
    protected Model $config;

    /**
     * @param array|Model $config
     */
    function __construct($config = [])
    {
        $this->config = $config instanceof Model ? $config : new ArrayOverload((array) $config);
    }
}
