<?php
/**
 *
 */

namespace Mvc5\Plugins;

use const Mvc5\CONFIG;

trait Config
{
    /**
     * @return array|\Mvc5\Config\Configuration|mixed
     */
    protected function config()
    {
        return $this->plugin(CONFIG);
    }
}
