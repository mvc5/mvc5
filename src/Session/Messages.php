<?php
/**
 *
 */

namespace Mvc5\Session;

use Mvc5\Arg;
use Mvc5\Config\Config as _Config;


class Messages
    implements SessionMessages
{
    /**
     *
     */
    use _Config;

    /**
     * @var array
     */
    protected $new = [];

    /**
     * @param string $message
     * @param mixed|string $type
     * @param string $name
     * @return mixed
     */
    function add($message, $type = Arg::INFO, $name = Arg::INDEX)
    {
        return $this->set($name, [Arg::MESSAGE => $message, Arg::TYPE => $type]);
    }

    /**
     * @param string $name
     * @return mixed
     */
    function message($name = Arg::INDEX)
    {
        ($message = $this->get($name))
            && $this->remove($name);

        return $message;
    }

    /**
     * @param string $name
     * @return void
     */
    function remove($name)
    {
        unset($this->config[$name], $this->new[$name]);
    }

    /**
     * @return string
     */
    function serialize()
    {
        return serialize($this->new);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    function set($name, $value)
    {
        return $this->config[$name] = $this->new[$name] = $value;
    }

    /**
     * @param string $serialized
     */
    function unserialize($serialized)
    {
        $this->config = unserialize($serialized);
    }

    /**
     * @param string $name
     * @return mixed
     */
    function __invoke($name = Arg::INDEX)
    {
        return $this->message($name);
    }
}
