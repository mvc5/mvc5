<?php
/**
 *
 */

namespace Mvc5\Response;

class Redirect
    extends Config
{
    /**
     * @param $url
     * @param int $status
     * @param array $headers
     * @param array $config
     */
    function __construct($url, $status = 302, array $headers = [], array $config = [])
    {
        parent::__construct(null, $status, $headers + ['Location' => (string) $url], $config);
    }
}
