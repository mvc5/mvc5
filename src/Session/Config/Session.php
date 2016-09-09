<?php
/**
 *
 */

namespace Mvc5\Session\Config;

use Mvc5\Arg;
use Mvc5\Config\ArrayAccess;
use Mvc5\Config\PropertyAccess;
use Mvc5\Cookie\Cookies;

trait Session
{
    /**
     *
     */
    use ArrayAccess;
    use PropertyAccess;

    /**
     * @var Cookies
     */
    protected $cookies;

    /**
     * @param Cookies $cookies
     */
    function __construct(Cookies $cookies)
    {
        $this->cookies = $cookies;
    }

    /**
     *
     */
    function close()
    {
        session_write_close();
    }

    /**
     * @return int
     */
    function count()
    {
        return count($_SESSION);
    }

    /**
     * @return mixed
     */
    function current()
    {
        return current($_SESSION);
    }

    /**
     * @param bool|true $cookie
     */
    function destroy($cookie = true)
    {
        session_destroy();

        if ($cookie) {
            $params = session_get_cookie_params();
            $this->cookies->remove($this->name(), $params[Arg::PATH], $params[Arg::DOMAIN], $params[Arg::SECURE]);
        }
    }

    /**
     * @param string $name
     * @return mixed
     */
    function &get($name)
    {
        return $_SESSION[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    function has($name)
    {
        return isset($_SESSION[$name]);
    }

    /**
     * @return string
     */
    function id()
    {
        return session_id();
    }

    /**
     * @return mixed
     */
    function key()
    {
        return key($_SESSION);
    }

    /**
     * @return string
     */
    function name()
    {
        return session_name();
    }

    /**
     *
     */
    function next()
    {
        next($_SESSION);
    }

    /**
     * @param mixed $name
     * @return mixed
     */
    function &offsetGet($name)
    {
        return $this->get($name);
    }

    /**
     * @param string $name
     * @return void
     */
    function remove($name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * @param bool|false $delete_old_session
     */
    function regenerate($delete_old_session = false)
    {
        session_regenerate_id($delete_old_session);
    }

    /**
     *
     */
    function rewind()
    {
        reset($_SESSION);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    function set($name, $value)
    {
        return $_SESSION[$name] = $value;
    }

    /**
     * @param array $options
     * @return bool
     */
    function start(array $options = [])
    {
        return PHP_SESSION_ACTIVE === $this->status() ?: session_start($options);
    }

    /**
     * @return int
     */
    function status()
    {
        return session_status();
    }

    /**
     * @return bool
     */
    function valid()
    {
        return null !== $this->key();
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

    /**
     * @param mixed $name
     * @return mixed
     */
    function &__get($name)
    {
        return $this->get($name);
    }
}
