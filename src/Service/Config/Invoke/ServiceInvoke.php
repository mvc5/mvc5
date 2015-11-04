<?php
/**
 *
 */

namespace Mvc5\Service\Config\Invoke;

interface ServiceInvoke
{
    /**
     * @return array
     */
    function args();

    /**
     * @return string|array
     */
    function config();
}
