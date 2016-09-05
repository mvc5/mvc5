<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;
use Mvc5\Cookie\Config as CookieConfig;
use Mvc5\Cookie\Sender;

class Cookies
    extends Dependency
{
    /**
     *
     */
    function __construct()
    {
        parent::__construct(Arg::COOKIES, [CookieConfig::class, new Sender, $_COOKIE]);
    }
}
