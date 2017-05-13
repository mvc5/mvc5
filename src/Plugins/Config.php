<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;

trait Config
{
    /**
     * @return array|\Mvc5\Config\Configuration|mixed
     */
    protected function config()
    {
        return $this->plugin(Arg::CONFIG);
    }
}
