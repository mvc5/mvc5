<?php
/**
 *
 */

namespace Mvc5\Session\Config;

use Mvc5\Config\Overload;
use Mvc5\Model\Config;
use Mvc5\Session\Session as _Session;

trait Container
{
    /**
     *
     */
    use Overload;

    /**
     * @var _Session
     */
    protected $container;

    /**
     * @var string
     */
    protected $label = self::class;

    /**
     * @param _Session $container
     * @param string $label
     */
    function __construct(_Session $container, $label = null)
    {
        $label && $this->label = $label;

        $this->container = $container;

        !isset($this->container[$this->label]) &&
            $this->reset();

        !$this->config &&
            $this->config = $this->container[$this->label];
    }

    /**
     *
     */
    function close()
    {
        return $this->container->close();
    }

    /**
     * @param bool|true $cookie
     */
    function destroy($cookie = true)
    {
        $this->container->destroy($cookie);
    }

    /**
     * @return string
     */
    function id()
    {
        return $this->container->id();
    }

    /**
     * @return string
     */
    function label()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    function name()
    {
        return $this->container->name();
    }

    /**
     * @param bool|false $delete_old_session
     */
    function regenerate($delete_old_session = false)
    {
        $this->container->regenerate($delete_old_session);
    }

    /**
     *
     */
    function reset()
    {
        return $this->container[$this->label] = $this->config = new Config;
    }

    /**
     * @return int
     */
    function status()
    {
        return $this->container->status();
    }

    /**
     * @param string $name
     * @param mixed $config
     * @return self|mixed
     */
    function with($name, $config)
    {
        $this->set($name, $config);
        return $this;
    }

    /**
     * @param string $name
     * @return self|mixed
     */
    function without($name)
    {
        $this->remove($name);
        return $this;
    }
}
