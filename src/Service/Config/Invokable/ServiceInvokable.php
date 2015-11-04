<?php
/**
 *
 */

namespace Mvc5\Service\Config\Invokable;

interface ServiceInvokable
{
    /**
     * @return array|callable|object|string
     */
    function config();
}
