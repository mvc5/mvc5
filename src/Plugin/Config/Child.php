<?php
/**
 *
 */

namespace Mvc5\Plugin\Config;

use Mvc5\Arg;

trait Child
{
    /**
     *
     */
    use Plugin;

    /**
     * @return string
     */
    public function parent()
    {
        return $this->get(Arg::PARENT);
    }
}
