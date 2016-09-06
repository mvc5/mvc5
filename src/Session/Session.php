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
     * @param bool|true $cookie
     */
    function destroy($cookie = true);

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
     * @return int
     */
    function status();
}
