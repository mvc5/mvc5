<?php
/**
 *
 */

namespace Mvc5\Config;

trait Config
{
    /**
     *
     */
    use ArrayAccess;

    /**
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->offsetGet($name);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return $this->offsetExists($name);
    }

    /**
     * @param string $name
     * @return void
     */
    public function remove($name)
    {
        $this->offsetUnset($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed $config
     */
    public function set($name, $value)
    {
        return $this->offsetSet($name, $value);
    }
}
