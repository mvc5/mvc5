<?php
/**
 *
 */

namespace Mvc5\Config;

trait PropertyAccess
{
    /**
     * @param string $name
     * @return mixed
     */
    abstract function get($name);

    /**
     * @param string $name
     * @return bool
     */
    abstract function has($name);

    /**
     * @param string $name
     * @return void
     */
    abstract function remove($name);

    /**
     * @param string $name
     * @param mixed $config
     * @return mixed $config
     */
    abstract function set($name, $config);

    /**
     * @param mixed $config
     * @return mixed
     */
    function __get($config)
    {
        return $this->get($config);
    }

    /**
     * @param mixed $config
     * @return bool
     */
    function __isset($config)
    {
        return $this->has($config);
    }

    /**
     * @param mixed $config
     * @param mixed $value
     * @return mixed $value
     */
    function __set($config, $value)
    {
        return $this->set($config, $value);
    }

    /**
     * @param mixed $config
     */
    function __unset($config)
    {
        $this->remove($config);
    }
}
