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
        return $this->get(Arg::ARGS) ? : [];
    }

    /**
     * @return array
     */
    public function calls()
    {
        return $this->get(Arg::CALLS) ? : [];
    }

    /**
     * @return bool
     */
    public function merge()
    {
        return $this->get(Arg::MERGE) ? : false;
    }

    /**
     * @return Plugin|string
     */
    public function name()
    {
        return $this->get(Arg::NAME);
    }

    /**
     * @return string
     */
    public function param()
    {
        return $this->get(Arg::PARAM);
    }
}
