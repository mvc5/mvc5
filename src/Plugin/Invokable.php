<?php
/**
 *
 */

namespace Mvc5\Plugin;

class Invokable
    implements Gem\Invokable
{
    /**
     * @var array|callable|object|Plugin|string
     */
    protected $config;

    /**
     * @param array|callable|object|string $config
     * @param array $args
     */
    public function __construct($config, array $args = [])
    {
        $this->args   = $args;
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function args()
    {
        return $this->args;
    }

    /**
     * @return array|callable|object|Plugin|string
     */
    public function config()
    {
        return $this->config;
    }
}
