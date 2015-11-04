<?php
/**
 *
 */

namespace Mvc5\Service\Config\Invokable;

use Mvc5\Service\Resolver\Resolvable;

class Invokable
    implements Resolvable, ServiceInvokable
{
    /**
     * @var array|callable|object|string
     */
    protected $config;

    /**
     * @param array|callable|object|string $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @return array|callable|object|string
     */
    public function config()
    {
        return $this->config;
    }
}
