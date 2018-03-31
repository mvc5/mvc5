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
     * @param string|null $name
     * @param string|null $type
     * @return array
     */
    protected function add($message, string $name = null, string $type = null) : array
    {
        return $this->set($name ?? Arg::INDEX, [Arg::MESSAGE => $message, Arg::TYPE => $this->type($type ?? Arg::INFO)]);
    }

    /**
     * @param array|string $message
     * @param string|null $name
     */
    function danger($message, string $name = null) : void
    {
        $this->add($message, $name, Arg::DANGER);
    }

    /**
     * @param array|string $message
     * @param string|null $name
     */
    function info($message, string $name = null) : void
    {
        $this->add($message, $name, Arg::INFO);
    }

    /**
     * @param array|string|null $name
     * @return array|null
     */
    function message($name = null)
    {
        null === $name && $name = Arg::INDEX;

        if (is_string($name)) {
            ($message = $this->get($name)) && $this->remove($name);
            return $message;
        }

        $matched = [];

        foreach($name as $key) {
            ($message = $this->get($key)) && $this->remove($key);

            $matched[$key] = $message;
        }

        return $matched;
    }

    /**
     * @param array|string $name
     */
    function remove($name) : void
    {
        foreach((array) $name as $key) {
            unset($this->config[$key], $this->new[$key]);
        }
    }

    /**
     * @return string
     */
    function serialize() : string
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
     * @param string|null $name
     */
    function success($message, string $name = null) : void
    {
        $this->add($message, $name, Arg::SUCCESS);
    }

    /**
     * @param string $type
     * @return string
     */
    protected function type(string $type) : string
    {
        return $this->types[$type] ?? $type;
    }

    /**
     * @param string $serialized
     */
    function unserialize($serialized) : void
    {
        $this->config = unserialize($serialized);
    }

    /**
     * @param array|string $message
     * @param string|null $name
     */
    function warning($message, string $name = null) : void
    {
        $this->add($message, $name, Arg::WARNING);
    }

    /**
     * @param array|string|null $name
     * @return array|null
     */
    function __invoke($name = null)
    {
        return $this->message($name);
    }
}
