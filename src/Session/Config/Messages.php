<?php
/**
 *
 */

namespace Mvc5\Session\Config;

use Mvc5\Arg;
use Mvc5\Config\Config;

trait Messages
{
    /**
     *
     */
    use Config;

    /**
     * @var array
     */
    protected $new = [];

    /**
     * @var array
     */
    protected $types = [
        Arg::DANGER  => Arg::DANGER,
        Arg::INFO    => Arg::INFO,
        Arg::SUCCESS => Arg::SUCCESS,
        Arg::WARNING => Arg::WARNING
    ];

    /**
     * @param array $types
     */
    function __construct(array $types = [])
    {
        $types && $this->types = $types + $this->types;
    }

    /**
     * @param string|array $message
     * @param string $name
     * @param string $type
     * @return array
     */
    protected function add($message, $name, $type)
    {
        return $this->set($name, [Arg::MESSAGE => $message, Arg::TYPE => $this->type($type)]);
    }

    /**
     * @param string|array $message
     * @param string $name
     * @return array
     */
    function danger($message, $name = Arg::INDEX)
    {
        return $this->add($message, $name, Arg::DANGER);
    }

    /**
     * @param string|array $message
     * @param string $name
     * @return array
     */
    function info($message, $name = Arg::INDEX)
    {
        return $this->add($message, $name, Arg::INFO);
    }

    /**
     * @param string $name
     * @return array
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
     * @param array $value
     * @return array
     */
    function set($name, $value)
    {
        return $this->config[$name] = $this->new[$name] = $value;
    }

    /**
     * @param string|array $message
     * @param string $name
     * @return array
     */
    function success($message, $name = Arg::INDEX)
    {
        return $this->add($message, $name, Arg::SUCCESS);
    }

    /**
     * @param $type
     * @return mixed
     */
    protected function type($type)
    {
        return $this->types[$type] ?? $type;
    }

    /**
     * @param string $serialized
     */
    function unserialize($serialized)
    {
        $this->config = unserialize($serialized);
    }

    /**
     * @param string|array $message
     * @param string $name
     * @return array
     */
    function warning($message, $name = Arg::INDEX)
    {
        return $this->add($message, $name, Arg::WARNING);
    }

    /**
     * @param string $name
     * @return array
     */
    function __invoke($name = Arg::INDEX)
    {
        return $this->message($name);
    }
}
