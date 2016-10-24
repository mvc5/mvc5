<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;
use Mvc5\Response\Json;
use Mvc5\Response\Redirect;
use Mvc5\Response\Response as _Response;

trait Response
{
    /**
     * @param $data
     * @param int $status
     * @param array $headers
     * @return Json
     */
    protected function json($data, $status = 200, array $headers = [])
    {
        return $this->plugin(Arg::RESPONSE_JSON, [$data, $status, $headers]);
    }

    /**
     * @param string $name
     * @param array $args
     * @param callable $callback
     * @return callable|null|object
     */
    protected abstract function plugin($name, array $args = [], callable $callback = null);

    /**
     * @param $url
     * @param int $status
     * @param array $headers
     * @param array $config
     * @return Redirect
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
     * @@return _Response
     */
    protected function response($body = null, $status = null, $headers = [], array $config = [])
    {
        return $this->plugin(Arg::RESPONSE, [$body, $status, $headers, $config]);
    }
}
