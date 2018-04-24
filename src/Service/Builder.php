<?php
/**
 *
 */

namespace Mvc5\Service;

use Mvc5\Exception;

final class Builder
    extends \ReflectionClass
{
    /**
     * @var array|self[]
     */
    protected static $class = [];

    /**
     * @var \ReflectionMethod|null
     */
    protected $constructor;

    /**
     * @var \ReflectionParameter[]
     */
    protected $params = [];

    /**
     * @param object|string $argument
     * @throws \ReflectionException
     */
    function __construct($argument)
    {
        parent::__construct($argument);

        ($this->constructor = $this->getConstructor())
            && $this->params = $this->constructor->getParameters();
    }

    /**
     * @param string $name
     * @param array $args
     * @param callable $callback
     * @return object
     * @throws \ReflectionException|\RuntimeException
     */
    static function create(string $name, array $args, callable $callback)
    {
        $class = static::reflectionClass($name);

        if (null === $class->constructor()) {
            return $class->newInstanceWithoutConstructor();
        }

        if ($args && !is_string(key($args))) {
            return new $name(...$args);
        }

        $matched = [];
        $params = $class->params();

        foreach($params as $param) {
            if ($param->isVariadic()) {
                $matched = array_merge($matched, array_values($args));
                break;
            }

            if (array_key_exists($param->name, $args)) {
                $matched[] = $args[$param->name];
                unset($args[$param->name]);
                continue;
            }

            if ($param->isOptional()) {
                $param->isDefaultValueAvailable() &&
                    $matched[] = $param->getDefaultValue();
                continue;
            }

            if (null !== ($hint = $param->getClass()) && null !== $match = $callback($hint->name)) {
                $matched[] = $match;
                continue;
            }

            if (null !== $match = $callback($param->name)) {
                $matched[] = $match;
                continue;
            }

            Exception::runtime('Missing required parameter $' . $param->name . ' for ' . $name);
        }

        return new $name(...($params ? $matched : array_values($args)));
    }

    /**
     * @return \ReflectionMethod|null
     */
    function constructor() : ?\ReflectionMethod
    {
        return $this->constructor;
    }

    /**
     * @return \ReflectionParameter[]
     */
    function params() : array
    {
        return $this->params;
    }

    /**
     * @param string $name
     * @return Builder
     * @throws \ReflectionException
     */
    static function reflectionClass(string $name) : self
    {
        return static::$class[$name] ?? (static::$class[$name] = new self($name));
    }
}
