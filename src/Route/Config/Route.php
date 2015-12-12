<?php
/**
 *
 */

namespace Mvc5\Route\Config;

use Mvc5\Arg;
use Mvc5\Config\Config;

trait Route
{
    /**
     *
     */
    use Config;

    /**
     * @return array|callable|null|object|string
     */
    public function controller()
    {
        return $this->get(Arg::CONTROLLER);
    }

    /**
     * @return string|string[]
     */
    public function hostname()
    {
        return $this->get(Arg::HOSTNAME);
    }

    /**
     * @return int
     */
    public function length()
    {
        return $this->get(Arg::LENGTH) ?: 0;
    }

    /**
     * @return bool
     */
    public function matched()
    {
        return $this->get(Arg::MATCHED) ?: false;
    }

    /**
     * @return string|string[]
     */
    public function method()
    {
        return $this->get(Arg::METHOD);
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->get(Arg::NAME);
    }

    /**
     * @return array
     */
    public function params()
    {
        return $this->get(Arg::PARAMS) ?: [];
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->get(Arg::PATH);
    }

    /**
     * @return string|string[]
     */
    public function scheme()
    {
        return $this->get(Arg::SCHEME);
    }
}
