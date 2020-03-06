<?php
/**
 *
 */

namespace Mvc5\Config;

trait Scope
{
    /**
     * @var bool|object|null
     */
    protected $scope;

    /**
     * @param mixed|object $context
     * @return Scopable|self
     */
    function withScope($context) : Scopable
    {
        $scope = $this->scope;

        if (! is_object($scope) || (! $scope instanceof $context && $scope !== $this)) {
            return clone $this;
        }

        $this->scope = null;

        $new = clone $this;
        $new->scope = $scope instanceof $context ? $context : $new;

        $this->scope = $scope;

        return $new;
    }
}
