<?php
/**
 *
 */

namespace Mvc5\Route\Match\Plugin;

use function is_string;

trait Params
{
    /**
     * @param array $match
     * @param array $params
     * @return array
     */
    protected function params(array $match, array $params = []) : array
    {
        foreach($match as $name => $value) {
            is_string($name) && $params[$name] = $value;
        }

        return $params;
    }
}
