<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Plugin;
use Mvc5\Service\Service as _Service;

trait Service
{
    /**
     *
     */
    use Plugin;

    /**
     * Service constructor.
     * @param _Service $service
     */
    function __construct(_Service $service)
    {
        $this->service = $service;
    }
}
