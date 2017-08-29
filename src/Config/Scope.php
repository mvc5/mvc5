<?php
/**
 *
 */

namespace Mvc5\Config;

interface Scope
{
    /**
     * @param bool|null|object $scope
     * @return bool|null|object
     */
    function scope($scope = null);
}
