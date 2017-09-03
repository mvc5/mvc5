<?php
/**
 *
 */

namespace Mvc5\Config;

interface Scope
{
    /**
     * @param bool|object|null $scope
     * @return bool|object|null
     */
    function scope($scope = null);
}
