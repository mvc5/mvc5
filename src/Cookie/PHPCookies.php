<?php
/**
 *
 */

namespace Mvc5\Cookie;

use Mvc5\ArrayObject;

final class PHPCookies
    extends ArrayObject
    implements Cookies
{
    /**
     *
     */
    use Config\PHPCookies;
}
