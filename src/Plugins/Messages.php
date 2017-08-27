<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;

trait Messages
{
    /**
     * @param array|string $message
     * @param string $name
     */
    protected function danger($message, $name = Arg::INDEX)
    {
        $this->messages()->danger($message, $name);
    }

    /**
     * @param array|string $message
     * @param string $name
     */
    protected function info($message, $name = Arg::INDEX)
    {
        $this->messages()->info($message, $name);
    }

    /**
     * @param string $name
     * @return array
     */
    protected function message($name = Arg::INDEX)
    {
        return $this->messages()->message($name);
    }

    /**
     * @return \Mvc5\Session\SessionMessages
     */
    protected function messages()
    {
        return $this->plugin(Arg::SESSION_MESSAGES);
    }

    /**
     * @param array|string $message
     * @param string $name
     */
    protected function success($message, $name = Arg::INDEX)
    {
        $this->messages()->success($message, $name);
    }

    /**
     * @param array|string $message
     * @param string $name
     */
    protected function warning($message, $name = Arg::INDEX)
    {
        $this->messages()->warning($message, $name);
    }
}
