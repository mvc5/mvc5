<?php
/**
 *
 */

namespace Mvc5\Cookie;

use Mvc5\Config\Configuration;

interface Cookies
    extends Configuration
{
    /**
     * @param string     $name
     * @param string     $path
     * @param string     $domain
     * @param bool|false $secure
     * @param bool|true  $httponly
     * @return bool
     */
    function remove($name, $path = null, $domain = null, $secure = null, $httponly = null);

    /**
     * @param string     $name
     * @param string     $value
     * @param int        $expire
     * @param string     $path
     * @param string     $domain
     * @param bool|false $secure
     * @param bool|true  $httponly
     * @return bool
     */
    function set($name, $value = null, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null);
}
