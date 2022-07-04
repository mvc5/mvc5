<?php
/**
 *
 */

namespace Mvc5\Session\Config;

use Mvc5\Config\ArrayAccess;
use Mvc5\Config\Count;
use Mvc5\Config\PropertyAccess;
use Mvc5\Cookie\PHPCookies;
use Mvc5\Session\Session;

use function count;
use function current;
use function is_string;
use function key;
use function next;
use function reset;
use function session_destroy;
use function session_get_cookie_params;
use function session_id;
use function session_name;
use function session_regenerate_id;
use function session_start;
use function session_status;
use function session_write_close;

use const PHP_SESSION_ACTIVE;

trait PHPSession
{
    /**
     *
     */
    use ArrayAccess;
    use Count;
    use PropertyAccess;

    /**
     *
     */
    function clear() : void
    {
        $_SESSION = [];
    }

    /**
     *
     */
    function close() : void
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
    function current() : mixed
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
            PHPCookies::delete($this->name(), session_get_cookie_params());

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
    function key() : ?string
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
    function next() : void
    {
        next($_SESSION);
    }

    /**
     * @param string $name
     * @return mixed
     */
    function &offsetGet($name) : mixed
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
    function remove($name) : void
    {
        foreach((array) $name as $key) {
            unset($_SESSION[$key]);
        }
    }

    /**
     *
     */
    function rewind() : void
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
     * @return Session|mixed
     */
    function with($name, $value = null) : Session
    {
        $this->set($name, $value);
        return $this;
    }

    /**
     * @param array|string $name
     * @return Session|mixed
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
