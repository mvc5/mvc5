<?php
/**
 *
 */

namespace Mvc5\Route\Match\Plugin;

trait Params
{
    /**
     * @param array $match
     * @param array $params
     * @return array
     */
    protected function params(array $match, array $params = [])
    {
        foreach($match as $name => $value) {
            is_string($name) && $params[$name] = $value;
        }

        return $params;
    }
}
