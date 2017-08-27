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
     * @param string $name
     * @param string $value
     * @param int|null|string $expire
     * @param string $path
     * @param string $domain
     * @param bool|false $secure
     * @param bool|true $httponly
     * @return self|mixed
     */
    function with($name, $value = '', $expire = null, string $path = null, string $domain = null, bool $secure = null, bool $httponly = null);

    /**
     * @param string $name
     * @param null|string $path
     * @param null|string $domain
     * @param bool|false $secure
     * @param bool|true $httponly
     * @return self|mixed
     */
    function without($name, string $path = null, string $domain = null, bool $secure = null, bool $httponly = null);
}
