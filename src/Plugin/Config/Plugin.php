<?php
/**
 *
 */

namespace Mvc5\Plugin\Config;

use Mvc5\Arg;
use Mvc5\Config\Config as Base;

trait Plugin
{
    /**
     *
     */
    use Base;

    /**
     * @return array
     */
    public function args()
    {
        return $this[Arg::ARGS] ? : [];
    }

    /**
     * @return array
     */
    public function calls()
    {
        return $this[Arg::CALLS] ? : [];
    }

    /**
     * @return bool
     */
    public function merge()
    {
        return $this[Arg::MERGE] ? : false;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this[Arg::NAME];
    }

    /**
     * @return string
     */
    public function param()
    {
        return $this[Arg::PARAM];
    }
}
