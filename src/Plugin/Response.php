<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;

class Response
    extends Plugin
{
    /**
     * @param string $event
     * @param array $args
     * @param array $calls
     */
    function __construct($event, array $args = [], array $calls = [])
    {
        parent::__construct(Arg::RESPONSE_DISPATCH, [Arg::EVENT => $event] + $args, $calls);
    }
}
