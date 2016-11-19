<?php
/**
 *
 */

namespace Mvc5;

class Exception
    extends \Exception
{
    /**
     * @param \Throwable $exception
     * @throws \Throwable
     */
    static function raise(\Throwable $exception)
    {
        throw $exception;
    }

    /**
     * @throws Exception
     */
    function __invoke()
    {
        return $this->raise($this);
    }
}
