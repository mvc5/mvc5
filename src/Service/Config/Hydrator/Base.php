<?php
/**
 *
 */

namespace Mvc5\Service\Config\Hydrator;

use Mvc5\Service\Config\Base as Config;
use Mvc5\Service\Config\Configuration;

trait Base
{
    /**
     *
     */
    use Config;

    /**
     * @param string $name
     * @param array $calls
     */
    public function __construct($name, array $calls)
    {
        $this->config = [
            Configuration::CALLS => $calls,
            Configuration::NAME  => $name
        ];
    }
}
