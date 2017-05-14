<?php
/**
 *
 */

namespace Mvc5\Response;

class JsonResponse
    extends HttpResponse
{
    /**
     * JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES
     */
    const ENCODE_OPTIONS = 79;

    /**
     * @param $data
     * @param int $status
     * @param array $headers
     */
    function __construct($data, $status = 200, array $headers = [])
    {
        parent::__construct(
            json_encode($data, static::ENCODE_OPTIONS), $status, $headers + ['Content-Type' => 'application/json']
        );
    }
}
