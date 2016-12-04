<?php
/**
 *
 */

namespace Mvc5\Cookie\Config;

trait Sender
{
    /**
     *
     */
    use Container;

    /**
     * @param $name
     * @param $value
     * @param $expire
     * @param $path
     * @param $domain
     * @param $secure
     * @param $httponly
     * @return bool
     */
    protected function setCookie($name, $value, $expire, $path, $domain, $secure, $httponly)
    {
        return setcookie(...array_values($this->cookie($name, $value, $expire, $path, $domain, $secure, $httponly)));
    }
}
