<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;
use Mvc5\Session\SessionMessages;

trait Messages
{
    /**
     * @param array|string $message
     * @param string $name
     */
    protected function danger($message, string $name = Arg::INDEX) : void
    {
        $this->messages()->danger($message, $name);
    }

    /**
     * @param array|string $message
     * @param string $name
     */
    protected function info($message, string $name = Arg::INDEX) : void
    {
        $this->messages()->info($message, $name);
    }

    /**
     * @param string $name
     * @return array
     */
    protected function message(string $name = Arg::INDEX) : array
    {
        return $this->messages()->message($name);
    }

    /**
     * @return SessionMessages
     */
    protected function messages() : SessionMessages
    {
        return $this->plugin(Arg::SESSION_MESSAGES);
    }

    /**
     * @param array|string $message
     * @param string $name
     */
    protected function success($message, string $name = Arg::INDEX) : void
    {
        $this->messages()->success($message, $name);
    }

    /**
     * @param array|string $message
     * @param string $name
     */
    protected function warning($message, string $name = Arg::INDEX) : void
    {
        $this->messages()->warning($message, $name);
    }
}
