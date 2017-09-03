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
     * @param int|string|null $expire
     * @param string|null $path
     * @param string|null $domain
     * @param bool|null $secure
     * @param bool|null $httponly
     * @return self|mixed
     */
    function with($name, $value = '', $expire = null, string $path = null, string $domain = null, bool $secure = null, bool $httponly = null);

    /**
     * @param string $name
     * @param string|null $path
     * @param string|null $domain
     * @param bool|null $secure
     * @param bool|null $httponly
     * @return self|mixed
     */
    function without($name, string $path = null, string $domain = null, bool $secure = null, bool $httponly = null);
}
