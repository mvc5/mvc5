<?php
/**
 *
 */

namespace Mvc5\Session;

use Mvc5\Config\Configuration;

interface Session
    extends Configuration
{
    /**
     *
     */
    function clear();

    /**
     *
     */
    function close();

    /**
     * @param bool|true $remove_session_cookie
     * @return bool
     */
    function destroy(bool $remove_session_cookie = true) : bool;

    /**
     * @param string|null $id
     * @return string
     */
    function id(string $id = null) : string;

    /**
     * @param string|null $name
     * @return string
     */
    function name(string $name = null) : string;

    /**
     * @param bool|false $delete_old_session
     * @return bool
     */
    function regenerate(bool $delete_old_session = false) : bool;

    /**
     * @param array $options
     * @return bool
     */
    function start(array $options = []) : bool;

    /**
     * @return int
     */
    function status() : int;
}
