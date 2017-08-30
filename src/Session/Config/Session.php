<?php
/**
 *
 */

namespace Mvc5\Session\Config;

use Mvc5\Arg;
use Mvc5\Config\ArrayAccess;
use Mvc5\Config\PropertyAccess;

trait Session
{
    /**
     *
     */
    use ArrayAccess;
    use PropertyAccess;

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
    function destroy(bool $remove_session_cookie = true)
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
     * @param null|string $id
     * @return string
     */
    function id(string $id = null)
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
     * @param null|string $name
     * @return string
     */
    function name(string $name = null)
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
    function regenerate(bool $delete_old_session = false)
    {
        session_regenerate_id($delete_old_session);
    }

    /**
     * @param array|string $name
     * @return void
     */
    function remove($name)
    {
        foreach((array) $name as $key) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * @param string $name
     * @param array $params
     */
    protected function removeSessionCookie(string $name, array $params = [])
    {
        setcookie($name, '', 946706400, $params[Arg::PATH], $params[Arg::DOMAIN], $params[Arg::SECURE]);
    }

    /**
     *
     */
    function rewind()
    {
        reset($_SESSION);
    }

    /**
     * @param array|string $name
     * @param mixed $value
     * @return mixed
     */
    function set($name, $value = null)
    {
        if (is_string($name)) {
            return $_SESSION[$name] = $value;
        }

        foreach($name as $key => $value) {
            $_SESSION[$key] = $value;
        }

        return $name;
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
     * @param array|string $name
     * @param mixed $value
     * @return self|mixed
     */
    function with($name, $value = null)
    {
        $this->set($name, $value);
        return $this;
    }

    /**
     * @param array|string $name
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
