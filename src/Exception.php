<?php
/**
 *
 */

namespace Mvc5;

class Exception
    extends \Exception
{
    /**
     * @throws Exception
     */
    function __invoke()
    {
        throw $this;
    }
}
