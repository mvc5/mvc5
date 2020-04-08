<?php
/**
 *
 */

namespace Mvc5\Plugin;

final class End
    extends Call
{
    /**
     * @param array ...$config
     */
    function __construct(...$config)
    {
        parent::__construct('@end', [new Args($config)]);
    }
}
