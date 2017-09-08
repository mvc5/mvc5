<?php
/**
 *
 */

namespace Mvc5\Cookie;

use Mvc5\Model;

class HttpCookies
    extends Model
    implements Cookies
{
    /**
     *
     */
    use Config\HttpCookies {
        remove as protected;
        set as protected;
    }
}
