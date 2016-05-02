<?php
/**
 *
 */

namespace Mvc5\Service\Config;

use Mvc5\Config\Config;
use Mvc5\Service\Scope as _Scope;

trait Scope
{
    /**
     *
     */
    use Config;

    /**
     *
     */
    function __clone()
    {
        if (!is_object($this->config)) {
            return;
        }

        if (!$this->config instanceof _Scope) {
            $this->config = clone $this->config;
            return;
        }

        $scope = $this->config->scope();

        if (!$scope instanceof self) {
            $this->config = clone $this->config;
            return;
        }

        $this->config->scope(false);

        $clone = clone $this->config;
        $clone->scope($this);

        $this->config->scope($scope);

        $this->config = $clone;
    }
}
