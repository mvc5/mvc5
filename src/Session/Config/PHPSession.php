<?php
/**
 *
 */

namespace Mvc5\Session\Config;

use Mvc5\Arg;
use Mvc5\Config\ArrayAccess;
use Mvc5\Config\PropertyAccess;
use Mvc5\Session\Session;

trait PHPSession
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
    function count() : int
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
    function destroy(bool $remove_session_cookie = true) : bool
    {
        $remove_session_cookie &&
            $this->removeSessionCookie($this->name(), session_get_cookie_params());

        return session_destroy();
    }

    /**
     * @param array|string $name
     * @return mixed
     */
    function get($name)
    {
        if (is_string($name)) {
            return $_SESSION[$name] ?? null;
        }

        $matched = [];

        foreach($name as $key) {
            $matched[$key] = $_SESSION[$key] ?? null;
        }

        return $matched;
    }

    /**
     * @param array|string $name
     * @return bool
     */
    function has($name) : bool
    {
        if (is_string($name)) {
            return isset($_SESSION[$name]);
        }

        foreach($name as $key) {
            if (!isset($_SESSION[$key])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string|null $id
     * @return string
     */
    function id(string $id = null) : string
    {
        return null !== $id ? session_id($id) : session_id();
    }

    /**
     * @return string|null
     */
    function key()
    {
        return key($_SESSION);
    }

    /**
     * @param string|null $name
     * @return string
     */
    function name(string $name = null) : string
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
     * @param string $name
     * @return mixed
     */
    function &offsetGet($name)
    {
        return $_SESSION[$name];
    }

    /**
     * @param bool|false $delete_old_session
     * @return bool
     */
    function regenerate(bool $delete_old_session = false) : bool
    {
        return session_regenerate_id($delete_old_session);
    }

    /**
     * @param array|string $name
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
     * @return bool
     */
    protected function removeSessionCookie(string $name, array $params = []) : bool
    {
        return setcookie($name, '', 946706400, $params[Arg::PATH], $params[Arg::DOMAIN], $params[Arg::SECURE]);
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
    function start(array $options = []) : bool
    {
        return PHP_SESSION_ACTIVE === $this->status() || session_start($options);
    }

    /**
     * @return int
     */
    function status() : int
    {
        return session_status();
    }

    /**
     * @return bool
     */
    function valid() : bool
    {
        return null !== $this->key();
    }

    /**
     * @param array|string $name
     * @param mixed $value
     * @return self|mixed
     */
    function with($name, $value = null) : Session
    {
        $this->set($name, $value);
        return $this;
    }

    /**
     * @param array|string $name
     * @return self|mixed
     */
    function without($name) : Session
    {
        $this->remove($name);
        return $this;
    }

    /**
     * @param string $name
     * @return mixed
     */
    function &__get($name)
    {
        return $this->offsetGet($name);
    }
}
