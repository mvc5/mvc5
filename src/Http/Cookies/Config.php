<?php
/**
 *
 */

namespace Mvc5\Http\Cookies;

use Mvc5\Http\Config\Cookies;
use Mvc5\Model;

class Config
    extends Model
    implements \Mvc5\Http\Cookies
{
    /**
     *
     */
    use Cookies;

    /**
     * @param array $cookies
     * @param array $defaults
     */
    function __construct(array $cookies = [], array $defaults = [])
    {
        $this->config = $cookies;
        $this->defaults = $defaults + $this->defaults;
    }
}
