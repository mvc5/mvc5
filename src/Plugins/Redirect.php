<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;
use Mvc5\Response\Redirect as RedirectResponse;

trait Redirect
{
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
     * @return RedirectResponse
     */
    protected function redirect($url, $status = 302, array $headers = [], array $config = [])
    {
        return $this->plugin(Arg::RESPONSE_REDIRECT, [$url, $status, $headers, $config]);
    }
}
