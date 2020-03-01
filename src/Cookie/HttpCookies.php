<?php
/**
 *
 */

namespace Mvc5\Cookie;

use Mvc5\ArrayModel;

class HttpCookies
    extends ArrayModel
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
