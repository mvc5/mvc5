<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use const Mvc5\{ CODE, DESCRIPTION, ERRORS, MESSAGE, STATUS };

trait Error
{
    /**
     * @return int|null
     */
    function code() : ?int
    {
        return $this[CODE];
    }

    /**
     * @return string|null
     */
    function description() : ?string
    {
        return $this[DESCRIPTION];
    }

    /**
     * @return array
     */
    function errors() : array
    {
        return $this[ERRORS] ?? [];
    }

    /**
     * @return array
     */
    function jsonSerialize() : array
    {
        return (null !== $this->code() ? [CODE => $this->code()] : [])
            + (null !== $this->message() ? [MESSAGE => $this->message()] : [])
            + (null !== $this->description() ? [DESCRIPTION => $this->description()] : [])
            + ($this->errors() ? [ERRORS => $this->errors()] : []);
    }

    /**
     * @return string|null
     */
    function message() : ?string
    {
        return $this[MESSAGE];
    }

    /**
     * @return int|null
     */
    function status() : ?int
    {
        return $this[STATUS];
    }
}
