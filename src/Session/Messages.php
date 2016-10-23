<?php
/**
 *
 */

namespace Mvc5\Session;

use Mvc5\Arg;

class Messages
    implements SessionMessages
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $current = [];

    /**
     * @param string $message
     * @param mixed|string $type
     * @param string $name
     * @return mixed
     */
    function flash($message, $type = Arg::INFO, $name = '')
    {
        return $this->current[$name] = $this->config[$name] = [Arg::MESSAGE => $message, Arg::TYPE => $type];
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function get($name)
    {
        return isset($this->current[$name]) ? $this->current[$name] : (
            isset($this->config[$name]) ? $this->config[$name] : null
        );
    }

    /**
     * @param string $name
     * @return mixed
     */
    function message($name = '')
    {
        ($message = $this->get($name))
            && $this->remove($name);

        return $message;
    }

    /**
     * @param string $name
     * @return void
     */
    protected function remove($name)
    {
        unset($this->current[$name], $this->config[$name]);
    }

    /**
     * @return string
     */
    function serialize()
    {
        return serialize($this->config);
    }

    /**
     * @param string $config
     */
    function unserialize($config)
    {
        $this->current = unserialize($config);
    }

    /**
     * @param string $name
     * @return mixed
     */
    function __invoke($name = '')
    {
        return $this->message($name);
    }
}
