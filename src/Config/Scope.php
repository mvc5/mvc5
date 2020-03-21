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

        if (! is_object($scope) || ($scope !== $this && ! $scope instanceof $context)) {
            return clone $this;
        }

        $this->scope = null;

        $new = clone $this;
        $new->scope = $scope === $this ? $new : $context;

        $this->scope = $scope;

        return $new;
    }
}
