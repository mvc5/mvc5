<?php
/**
 *
 */

namespace Mvc5;

use ReflectionFunction;
use ReflectionMethod;

trait Signal
{
    /**
     * @param callable|object $config
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    protected static function signal(callable $config, array $args = [], callable $callback = null)
    {
        if ($args && !is_string(key($args))) {
            return $config(...$args);
        }

        $function = null;
        $matched  = [];
        $method   = '__invoke';
        $params   = [];

        if (is_string($config)) {
            $static = explode('::', $config);
            if (isset($static[1])) {
                list($config, $method) = $static;
            } else {
                $params   = (new ReflectionFunction($config))->getParameters();
                $function = $config;
            }
        }

        is_array($config) && list($config, $method) = $config;

        !$function && ($function = [$config, $method])
            && $params = (new ReflectionMethod($config, $method))->getParameters();

        foreach($params as $param) {
            if (array_key_exists($param->name, $args)) {
                $matched[] = $args[$param->name];
                continue;
            }

            if (Arg::ARGS === $param->name) {
                $matched[] = $param->isVariadic() ? new Plugin\SignalArgs($args) : $args;
                continue;
            }

            if ($param->isOptional()) {
                $param->isDefaultValueAvailable() &&
                    $matched[] = $param->getDefaultValue();
                continue;
            }

            if ($callback && null !== $match = $callback($param->name)) {
                $matched[] = $match;
                continue;
            }

            if ($callback && $hint = $param->getClass()) {
                $matched[] = $callback($hint->name);
                continue;
            }

            Exception::runtime('Missing required parameter $' . $param->name . ' for ' . (
                is_string($function) ? $function : (
                    (is_string($config) ? $config : get_class($config)) . '::' . $method
                )
            ));
        }

        return $function(...($params ? $matched : array_values($args)));
    }
}
