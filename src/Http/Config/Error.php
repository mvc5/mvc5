<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;

trait Error
{
    /**
     * @return int|null
     */
    function code() : ?int
    {
        return $this[Arg::CODE];
    }

    /**
     * @return string|null
     */
    function description() : ?string
    {
        return $this[Arg::DESCRIPTION];
    }

    /**
     * @return array
     */
    function errors() : array
    {
        return $this[Arg::ERRORS] ?? [];
    }

    /**
     * @return array
     */
    function jsonSerialize() : array
    {
        return (null !== $this->code() ? [Arg::CODE => $this->code()] : [])
            + (null !== $this->message() ? [Arg::MESSAGE => $this->message()] : [])
            + (null !== $this->description() ? [Arg::DESCRIPTION => $this->description()] : [])
            + ($this->errors() ? [Arg::ERRORS => $this->errors()] : []);
    }

    /**
     * @return string|null
     */
    function message() : ?string
    {
        return $this[Arg::MESSAGE];
    }

    /**
     * @return int|null
     */
    function status() : ?int
    {
        return $this[Arg::STATUS];
    }
}
