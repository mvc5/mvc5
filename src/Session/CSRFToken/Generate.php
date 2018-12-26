<?php
/**
 *
 */

namespace Mvc5\Session\CSRFToken;

use Mvc5\Arg;
use Mvc5\Session\Session;

use function bin2hex;
use function random_bytes;

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
        (!isset($session[Arg::CSRF_TOKEN]) || $override) &&
            $session[Arg::CSRF_TOKEN] = bin2hex(random_bytes(32));

        return $session;
    }
}
