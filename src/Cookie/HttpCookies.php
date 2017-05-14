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
    use Config\Cookies {
        remove as protected;
        set as protected;
    }
}
