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
     * @param string $message
     * @param string $name
     */
    protected function danger($message, $name = Arg::INDEX)
    {
        $this->messages()->add($message, Arg::DANGER, $name);
    }

    /**
     * @param string $message
     * @param string $name
     */
    protected function info($message, $name = Arg::INDEX)
    {
        $this->messages()->add($message, Arg::INFO, $name);
    }

    /**
     * @param $name
     * @return array
     */
    protected function message($name = Arg::INDEX)
    {
        return $this->messages()->message($name);
    }

    /**
     * @return SessionMessages
     */
    protected function messages()
    {
        return $this->plugin(Arg::SESSION_MESSAGES);
    }

    /**
     * @param string $message
     * @param string $name
     */
    protected function success($message, $name = Arg::INDEX)
    {
        $this->messages()->add($message, Arg::SUCCESS, $name);
    }

    /**
     * @param string $message
     * @param string $name
     */
    protected function warning($message, $name = Arg::INDEX)
    {
        $this->messages()->add($message, Arg::WARNING, $name);
    }

    /**
     * @param string $name
     * @param array $args
     * @param callable $callback
     * @return callable|null|object
     */
    protected abstract function plugin($name, array $args = [], callable $callback = null);
}
