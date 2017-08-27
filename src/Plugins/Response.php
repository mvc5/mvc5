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
     * @return \Mvc5\Response\JsonResponse|mixed
     */
    protected function json($data, int $status = 200, array $headers = [])
    {
        return $this->plugin(Arg::RESPONSE_JSON, [$data, $status, $headers]);
    }

    /**
     * @param $url
     * @param int $status
     * @param array $headers
     * @param array $config
     * @return \Mvc5\Response\RedirectResponse|mixed
     */
    protected function redirect($url, int $status = 302, array $headers = [], array $config = [])
    {
        return $this->plugin(Arg::RESPONSE_REDIRECT, [$url, $status, $headers, $config]);
    }

    /**
     * @param null $body
     * @param int $status
     * @param array $headers
     * @param array $config
     * @@return \Mvc5\Response\Response|mixed
     */
    protected function response($body = null, int $status = null, $headers = [], array $config = [])
    {
        return $this->plugin(Arg::RESPONSE, [$body, $status, $headers, $config]);
    }
}
