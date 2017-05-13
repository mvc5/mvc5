<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;

trait Response
{
    /**
     * @param $data
     * @param int $status
     * @param array $headers
     * @return \Mvc5\Response\Json|mixed
     */
    protected function json($data, $status = 200, array $headers = [])
    {
        return $this->plugin(Arg::RESPONSE_JSON, [$data, $status, $headers]);
    }

    /**
     * @param $url
     * @param int $status
     * @param array $headers
     * @param array $config
     * @return \Mvc5\Response\Redirect|mixed
     */
    protected function redirect($url, $status = 302, array $headers = [], array $config = [])
    {
        return $this->plugin(Arg::RESPONSE_REDIRECT, [$url, $status, $headers, $config]);
    }

    /**
     * @param null $body
     * @param string $status
     * @param array $headers
     * @param array $config
     * @@return \Mvc5\Response\Response|mixed
     */
    protected function response($body = null, $status = null, $headers = [], array $config = [])
    {
        return $this->plugin(Arg::RESPONSE, [$body, $status, $headers, $config]);
    }
}
