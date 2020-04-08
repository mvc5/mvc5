<?php
/**
 *
 */

namespace Mvc5\Plugin;

use const Mvc5\{ EVENT, REQUEST, RESPONSE, RESPONSE_DISPATCH };

final class Response
    extends Plugin
{
    /**
     * @param string $event
     * @param array $args
     * @param array $calls
     */
    function __construct(string $event, array $args = [], array $calls = [])
    {
        parent::__construct(RESPONSE_DISPATCH, $this->eventArgs($event, $args), $calls);
    }

    /**
     * @param string $event
     * @param array $args
     * @return array
     */
    protected function eventArgs(string $event, array $args) : array
    {
        return [EVENT => $event] + $args + [
            REQUEST => new Plugin('request'), RESPONSE => new Plugin('response')
        ];
    }
}
