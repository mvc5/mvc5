<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Config\Base as ConfigBase;

trait Base
{
    /**
     *
     */
    use ConfigBase;

    /**
     * @return array|callable|null|object|string
     */
    public function controller()
    {
        return $this->get(Route::CONTROLLER);
    }

    /**
     * @return string|string[]
     */
    public function hostname()
    {
        return $this->get(Route::HOSTNAME);
    }

    /**
     * @return int
     */
    public function length()
    {
        return $this->get(Route::LENGTH) ?: 0;
    }

    /**
     * @return bool
     */
    public function matched()
    {
        return $this->get(Route::MATCHED) ?: false;
    }

    /**
     * @return string|string[]
     */
    public function method()
    {
        return $this->get(Route::METHOD);
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->get(Route::NAME);
    }

    /**
     * @return array
     */
    public function params()
    {
        return $this->get(Route::PARAMS) ?: [];
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->get(Route::PATH);
    }

    /**
     * @return string|string[]
     */
    public function scheme()
    {
        return $this->get(Route::SCHEME);
    }
}
