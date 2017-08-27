<?php
/**
 *
 */

namespace Mvc5\Session\Config;

use Mvc5\Arg;

trait Messages
{
    /**
     * @var array
     */
    protected $config = [];

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
        $this->types = $types + $this->types;
    }

    /**
     * @param array|string $message
     * @param string $name
     * @param string $type
     * @return array
     */
    protected function add($message, string $name, string $type)
    {
        return $this->set($name, [Arg::MESSAGE => $message, Arg::TYPE => $this->type($type)]);
    }

    /**
     * @param array|string $message
     * @param string $name
     * @return array
     */
    function danger($message, string $name = Arg::INDEX)
    {
        return $this->add($message, $name, Arg::DANGER);
    }

    /**
     * @param array|string $message
     * @param string $name
     * @return array
     */
    function info($message, string $name = Arg::INDEX)
    {
        return $this->add($message, $name, Arg::INFO);
    }

    /**
     * @param string $name
     * @return array
     */
    function message(string $name = Arg::INDEX)
    {
        ($message = $this->get($name))
            && $this->remove($name);

        return $message;
    }

    /**
     * @param array|string $name
     * @return void
     */
    function remove($name)
    {
        foreach((array) $name as $key) {
            unset($this->config[$key], $this->new[$key]);
        }
    }

    /**
     * @return string
     */
    function serialize()
    {
        return serialize($this->new);
    }

    /**
     * @param array|string $name
     * @param array $value
     * @return array
     */
    function set($name, $value = null)
    {
        if (is_string($name)) {
            return $this->config[$name] = $this->new[$name] = $value;
        }

        foreach($name as $key => $value) {
            $this->config[$key] = $this->new[$key] = $value;
        }

        return $name;
    }

    /**
     * @param array|string $message
     * @param string $name
     * @return array
     */
    function success($message, string $name = Arg::INDEX)
    {
        return $this->add($message, $name, Arg::SUCCESS);
    }

    /**
     * @param string $type
     * @return string
     */
    protected function type(string $type)
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
     * @param array|string $message
     * @param string $name
     * @return array
     */
    function warning($message, string $name = Arg::INDEX)
    {
        return $this->add($message, $name, Arg::WARNING);
    }

    /**
     * @param string $name
     * @return array
     */
    function __invoke(string $name = Arg::INDEX)
    {
        return $this->message($name);
    }
}
