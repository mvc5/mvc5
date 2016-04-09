<?php
/**
 *
 */

namespace Mvc5\Service;

interface Scope
{
    /**
     * @param null|object $scope
     * @return null|object
     */
    function scope($scope = null);
}
