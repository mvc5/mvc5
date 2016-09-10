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
    function close();

    /**
     * @param bool|true $remove_session_cookie
     * @return bool
     */
    function destroy($remove_session_cookie = true);

    /**
     * @return string
     */
    function id();

    /**
     * @return string
     */
    function name();

    /**
     * @param bool|false $delete_old_session
     */
    function regenerate($delete_old_session = false);

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
