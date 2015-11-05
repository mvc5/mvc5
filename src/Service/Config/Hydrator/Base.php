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
     * @param null|string $param
     */
    public function __construct($name, array $calls, $param = ServiceHydrator::ITEM)
    {
        $this->config = [
            Configuration::CALLS => $calls,
            Configuration::NAME  => $name,
            Configuration::PARAM => $param
        ];
    }
}
