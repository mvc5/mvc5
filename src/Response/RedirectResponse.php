<?php
/**
 *
 */

namespace Mvc5\Response;

class RedirectResponse
    extends HttpResponse
{
    /**
     * @param string $url
     * @param int $status
     * @param array $headers
     * @param array $config
     */
    function __construct(string $url, int $status = 302, array $headers = [], array $config = [])
    {
        parent::__construct(null, $status, $headers + ['Location' => $url], $config);
    }
}
