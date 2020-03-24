<?php
/**
 *
 */

namespace Mvc5\Session\CSRFToken;

use Mvc5\Session\Session;

use function bin2hex;
use function random_bytes;

use const Mvc5\{ CSRF_TOKEN };

class Generate
{
    /**
     * @param Session $session
     * @param bool $override
     * @return Session
     * @throws \Exception
     */
    function __invoke(Session $session, bool $override = false) : Session
    {
        (!isset($session[CSRF_TOKEN]) || $override) &&
            $session[CSRF_TOKEN] = bin2hex(random_bytes(32));

        return $session;
    }
}
