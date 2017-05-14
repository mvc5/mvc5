<?php
/**
 *
 */

namespace Mvc5\Cookie;

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
     * @return self|mixed
     */
    function with($name, $value = '', $expire = null, $path = null, $domain = null, $secure = null, $httponly = null);

    /**
     * @param string     $name
     * @param string     $path
     * @param string     $domain
     * @param bool|false $secure
     * @param bool|true  $httponly
     * @return self|mixed
     */
    function without($name, $path = null, $domain = null, $secure = null, $httponly = null);
}
