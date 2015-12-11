<?php
/**
 *
 */

namespace Mvc5\Route\Config;

use Mvc5\Arg;

trait Error
{
    /**
     *
     */
    use Route;

    /**
     * @return mixed
     */
    public function route()
    {
        return $this->get(Arg::ROUTE);
    }
}
