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
    function __construct(Cookies $cookies = null)
    {
        $this->cookies = $cookies;
    }

    /**
     *
     */
    function abort()
    {
        session_abort();
    }

    /**
     *
     */
    function clear()
    {
        $_SESSION = [];
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
     * @param bool $remove_session_cookie
     * @return bool
     */
    function destroy($remove_session_cookie = true)
    {
        $remove_session_cookie &&
            $this->removeSessionCookie($this->name(), session_get_cookie_params());

        return session_destroy();
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
     * @param string $id
     * @return string
     */
    function id($id = null)
    {
        return null !== $id ? session_id($id) : session_id();
    }

    /**
     * @return mixed
     */
    function key()
    {
        return key($_SESSION);
    }

    /**
     * @param string $name
     * @return string
     */
    function name($name = null)
    {
        return null !== $name ? session_name($name) : session_name();
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
     * @param bool|false $delete_old_session
     */
    function regenerate($delete_old_session = false)
    {
        session_regenerate_id($delete_old_session);
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
     * @param $name
     * @param array $params
     */
    protected function removeSessionCookie($name, array $params = [])
    {
        $this->cookies ?
            $this->cookies->remove($name, $params[Arg::PATH], $params[Arg::DOMAIN], $params[Arg::SECURE])
                : setcookie($name, false, 946706400, $params[Arg::PATH], $params[Arg::DOMAIN], $params[Arg::SECURE]);
    }

    /**
     *
     */
    function reset()
    {
        session_reset();
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
