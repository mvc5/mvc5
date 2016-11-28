<?php
/**
 *
 */

namespace Mvc5\Service;

final class Alias
{
    /**
     * @var array
     */
    protected $alias = [];

    /**
     * @param array $alias
     */
    function __construct(array $alias = [])
    {
        $this->alias = $alias;
    }

    /**
     * @param $name
     * @return bool
     */
    function __invoke($name)
    {
        return isset($this->alias[$name]) && class_alias($this->alias[$name], $name, true);
    }
}
