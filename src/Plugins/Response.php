<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;
use Mvc5\Http;

trait Response
{
    /**
     * @param $data
     * @param int $status
     * @param array $headers
     * @return Http\Response|\Mvc5\Response\JsonResponse|mixed
     */
    protected function json($data, int $status = 200, array $headers = []) : Http\Response
    {
        return $this->plugin(Arg::RESPONSE_JSON, [$data, $status, $headers]);
    }

    /**
     * @param array|string|\Mvc5\Http\Uri $url
     * @param int $status
     * @param array $headers
     * @param array $config
     * @return Http\Response|\Mvc5\Response\RedirectResponse|mixed
     */
    protected function redirect($url, int $status = 302, array $headers = [], array $config = []) : Http\Response
    {
        return $this->plugin(Arg::RESPONSE_REDIRECT, [$url, $status, $headers, $config]);
    }

    /**
     * @param mixed $body
     * @param int|null $status
     * @param array $headers
     * @param array $config
     * @return Http\Response|\Mvc5\Response\Response|mixed
     */
    protected function response($body = null, int $status = null, $headers = [], array $config = []) : Http\Response
    {
        return $this->plugin(Arg::RESPONSE, [$body, $status, $headers, $config]);
    }
}
