<?php
/**
 *
 */

namespace Mvc5\Cookie\Config;

use Mvc5\Arg;
use Mvc5\Cookie\Cookies;

use function array_values;
use function is_string;
use function key;
use function setcookie;
use function version_compare;

trait PHPCookies
{
    /**
     *
     */
    use HttpCookies;

    /**
     * @param array|null $cookies
     * @param array $defaults
     */
    function __construct(array $cookies = null, array $defaults = [])
    {
        $this->config = $cookies ?? $_COOKIE;
        $this->defaults = $defaults + $this->defaults;
    }

    /**
     * @param array $cookie
     * @param array $defaults
     * @return bool
     */
    static function send(array $cookie, array $defaults = []) : bool
    {
        return send(is_string(key($cookie)) ? $cookie : cookie(...$cookie), $defaults);
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $options
     * @return mixed
     */
    function set($name, $value = '', array $options = [])
    {
        if (is_array($name)) {
            $this->send($name, $this->defaults);
            return $name;
        }

        $this->send([Arg::NAME => (string) $name, Arg::VALUE => (string) $value] + $options, $this->defaults);

        return $value;
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $options
     * @return self|mixed
     */
    function with($name, $value = null, array $options = []) : Cookies
    {
        $this->set($name, $value, $options);
        return $this;
    }

    /**
     * @param string $name
     * @param array $options
     * @return self|mixed
     */
    function without($name, array $options = []) : Cookies
    {
        $this->remove($name, $options);
        return $this;
    }
}

/**
 * @param array $cookie
 * @param array $defaults
 * @return bool
 */
function send(array $cookie, array $defaults = []) : bool
{
    return version_compare(\PHP_VERSION, '7.3', '<') ?
        setcookie((string) $cookie[Arg::NAME], (string) $cookie[Arg::VALUE], ...array_values(options($cookie, $defaults, false)))
        : setcookie((string) $cookie[Arg::NAME], (string) $cookie[Arg::VALUE], options($cookie, $defaults));
}
