<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;

trait User
{
    /**
     * @return mixed
     */
    protected function user()
    {
        return $this->plugin(Arg::USER);
    }
}
