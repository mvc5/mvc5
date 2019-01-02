<?php
/**
 *
 */

namespace Mvc5\Http;

use Mvc5\Arg;

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
        parent::__construct([Arg::HEADERS => ['location' => $url] + $headers, Arg::STATUS => $status]);
    }
}
