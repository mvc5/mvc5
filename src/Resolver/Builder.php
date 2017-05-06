<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Exception;

final class Builder
    extends \ReflectionClass
{
    /**
     * @var array|self[]
     */
    protected static $class = [];

    /**
     * @var \ReflectionMethod
     */
    protected $constructor;

    /**
     * @var \ReflectionParameter[]
     */
    protected $params;

    /**
     * @param $name
     * @param array $args
     * @param callable $callback
     * @return object
     */
    static function create($name, array $args, callable $callback)
    {
        $class = static::reflectionClass($name);

        if (!$class->constructor()) {
            return $class->newInstanceWithoutConstructor();
        }

        if ($args && !is_string(key($args))) {
            return new $name(...$args);
        }

        $matched = [];
        $params  = $class->params();

        foreach($params as $param) {
            if (array_key_exists($param->name, $args)) {
                $matched[] = $args[$param->name];
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
     * @return bool|\ReflectionMethod
     */
    protected function constructor()
    {
        return $this->constructor ?? $this->constructor = (parent::getConstructor() ?: false);
    }

    /**
     * @param \ReflectionMethod|null $method
     * @return array|\ReflectionParameter[]
     */
    protected function constructorParams($method)
    {
        return $method ? $method->getParameters() : [];
    }

    /**
     * @return \ReflectionParameter[]
     */
    protected function params()
    {
        return $this->params ?? $this->params = $this->constructorParams($this->constructor());
    }

    /**
     * @param $name
     * @return self
     */
    static function reflectionClass($name)
    {
        return static::$class[$name] ?? (static::$class[$name] = new self($name));
    }
}
