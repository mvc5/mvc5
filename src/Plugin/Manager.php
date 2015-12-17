<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;

class Manager
    implements Gem\Child
{
    /**
     *
     */
    use Config\Child;

    /**
     * @param string $name
     * @param array $calls
     */
    public function __construct($name, array $calls = [])
    {
        $this->config = [
            Arg::CALLS  => $calls + [
                    Arg::CONFIG   => new Config,
                    Arg::ALIASES  => new Param(Arg::ALIAS),
                    Arg::SERVICES => new Param(Arg::SERVICES),
                    Arg::EVENTS   => new Param(Arg::EVENTS)
            ],
            Arg::MERGE  => true,
            Arg::NAME   => $name,
            Arg::PARENT => Arg::MANAGER
        ];
    }
}
