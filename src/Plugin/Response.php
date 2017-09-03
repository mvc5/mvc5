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
    function __construct(string $event, array $args = [], array $calls = [])
    {
        parent::__construct(Arg::RESPONSE_DISPATCH, $this->eventArgs($event, $args), $calls);
    }

    /**
     * @param string $event
     * @param array $args
     * @return array
     */
    protected function eventArgs(string $event, array $args) : array
    {
        return [Arg::EVENT => $event] + $args + [
            Arg::REQUEST => new Plugin('request'), Arg::RESPONSE => new Plugin('response')
        ];
    }
}
