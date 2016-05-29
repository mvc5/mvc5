<?php
/**
 *
 */

namespace Mvc5\Response;

class Json
    extends Config
{
    /**
     * @param $data
     * @param int $status
     * @param array $headers
     */
    function __construct($data, $status = 200, array $headers = [])
    {
        parent::__construct($this->encode($data), $status, $headers + ['Content-Type' => 'application/json']);
    }

    /**
     * @param $data
     * @return string
     */
    protected function encode($data)
    {
        return json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES);
    }
}
