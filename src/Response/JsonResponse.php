<?php
/**
 *
 */

namespace Mvc5\Response;

use Mvc5\Exception;

use function json_encode;
use function json_last_error;
use function json_last_error_msg;

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
     * @throws \InvalidArgumentException|\Throwable
     */
    function __construct($data, int $status = 200, array $headers = [])
    {
        parent::__construct($this->result(json_encode($data, static::ENCODE_OPTIONS)),
            $status, $headers + ['content-type' => 'application/json']
        );
    }

    /**
     * @param $result
     * @return string
     * @throws \InvalidArgumentException|\Throwable
     */
    protected function result($result) : string
    {
        return JSON_ERROR_NONE === json_last_error() ? $result :
            Exception::invalidArgument('JSON Encode Error: ' . json_last_error_msg());
    }
}
