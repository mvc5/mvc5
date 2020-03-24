<?php
/**
 *
 */

namespace Mvc5\Plugins;

use const Mvc5\USER;

trait User
{
    /**
     * @return mixed
     */
    protected function user()
    {
        return $this->plugin(USER);
    }
}
