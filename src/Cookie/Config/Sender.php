<?php
/**
 *
 */

namespace Mvc5\Cookie\Config;

use Mvc5\Arg;
use Mvc5\Signal;

trait Sender
{
    /**
     *
     */
    use Container;
    use Signal;

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
        return $this->signal(
            Arg::SET_COOKIE, array_values($this->cookie($name, $value, $expire, $path, $domain, $secure, $httponly))
        );
    }
}
