<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Session\SessionMessages;

use const Mvc5\SESSION_MESSAGES;

trait Messages
{
    /**
     * @param array|string $message
     * @param string|null $name
     */
    protected function danger($message, string $name = null) : void
    {
        $this->messages()->danger($message, $name);
    }

    /**
     * @param array|string $message
     * @param string|null $name
     */
    protected function info($message, string $name = null) : void
    {
        $this->messages()->info($message, $name);
    }

    /**
     * @param array|string|null $name
     * @return array|null
     */
    protected function message($name = null)
    {
        return $this->messages()->message($name);
    }

    /**
     * @return SessionMessages
     */
    protected function messages() : SessionMessages
    {
        return $this->plugin(SESSION_MESSAGES);
    }

    /**
     * @param array|string $message
     * @param string|null $name
     */
    protected function success($message, string $name = null) : void
    {
        $this->messages()->success($message, $name);
    }

    /**
     * @param array|string $message
     * @param string|null $name
     */
    protected function warning($message, string $name = null) : void
    {
        $this->messages()->warning($message, $name);
    }
}
