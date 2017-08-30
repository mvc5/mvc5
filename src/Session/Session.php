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
    function destroy(bool $remove_session_cookie = true);

    /**
     * @param null|string $id
     * @return string
     */
    function id(string $id = null);

    /**
     * @param null|string $name
     * @return string
     */
    function name(string $name = null);

    /**
     * @param bool|false $delete_old_session
     */
    function regenerate(bool $delete_old_session = false);

    /**
     * @param array $options
     * @return bool
     */
    function start(array $options = []);

    /**
     * @return int
     */
    function status();
}
