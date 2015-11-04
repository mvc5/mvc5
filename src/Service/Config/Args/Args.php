<?php
/**
 *
 */

namespace Mvc5\Service\Config\Args;

use Mvc5\Service\Resolver\Resolvable;

class Args
    implements Arguments, Resolvable
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function config()
    {
        return $this->config;
    }
}
