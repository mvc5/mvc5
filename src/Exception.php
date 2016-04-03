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
    public function __invoke()
    {
        throw $this;
    }
}
