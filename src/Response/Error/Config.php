<?php
/**
 *
 */

namespace Mvc5\Response\Error;

use Mvc5\Arg;
use Mvc5\Config\Config as Base;

trait Config
{
    /**
     *
     */
    use Base;

    /**
     * @return int
     */
    public function code()
    {
        return $this[Arg::CODE];
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this[Arg::DESCRIPTION];
    }

    /**
     * @return array
     */
    public function errors()
    {
        return $this[Arg::ERRORS];
    }

    /**
     * @return string
     */
    public function message()
    {
        return $this[Arg::MESSAGE];
    }

    /**
     * @return int
     */
    public function status()
    {
        return $this[Arg::STATUS];
    }
}
