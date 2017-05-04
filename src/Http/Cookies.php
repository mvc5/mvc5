<?php
/**
 *
 */

namespace Mvc5\Http;

use Mvc5\Config\Model;

interface Cookies
    extends Model
{
    /**
     * @param string     $name
     * @param string     $value
     * @param int        $expire
     * @param string     $path
     * @param string     $domain
     * @param bool|false $secure
     * @param bool|true  $httponly
     * @return string
     */
    function withCookie($name, $value = null, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null);

    /**
     * @param string     $name
     * @param string     $path
     * @param string     $domain
     * @param bool|false $secure
     * @param bool|true  $httponly
     */
    function withoutCookie($name, $path = null, $domain = null, $secure = null, $httponly = null);
}
