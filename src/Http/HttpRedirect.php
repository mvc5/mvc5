<?php
/**
 *
 */

namespace Mvc5\Http;

use const Mvc5\{ HEADERS, STATUS };

class HttpRedirect
    extends HttpResponse
{
    /**
     * @param string $url
     * @param int $status
     * @param array $headers
     */
    function __construct(string $url, int $status = 302, array $headers = [])
    {
        parent::__construct([HEADERS => ['location' => $url] + $headers, STATUS => $status]);
    }
}
