<?php
/**
 *
 */

namespace Mvc5\Route\Config;

use Mvc5\Arg;
use Throwable;

trait Exception
{
    /**
     *
     */
    use Error;

    /**
     * @return Throwable
     */
    public function exception()
    {
        return $this->get(Arg::EXCEPTION);
    }
}
