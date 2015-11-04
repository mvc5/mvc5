<?php
/**
 *
 */

namespace Mvc5\Service\Config;

use Mvc5\Config\Base as BaseConfig;

trait Base
{
    /**
     *
     */
    use BaseConfig;

    /**
     * @return array
     */
    public function args()
    {
        return $this->get(Configuration::ARGS) ? : [];
    }

    /**
     * @return array
     */
    public function calls()
    {
        return $this->get(Configuration::CALLS) ? : [];
    }

    /**
     * @return bool
     */
    public function merge()
    {
        return $this->get(Configuration::MERGE) ? : false;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->get(Configuration::NAME);
    }

    /**
     * @return string
     */
    public function param()
    {
        return $this->get(Configuration::PARAM) ? : Configuration::PARAM;
    }
}
