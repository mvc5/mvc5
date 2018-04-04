<?php
/**
 *
 */
namespace Mvc5\Response\Emitter;

use Mvc5\Response\Emitter;

class PassThru
    implements Emitter
{
    /**
     * @var string
     */
    protected $command;

    /**
     * @param string $command
     */
    function __construct(string $command)
    {
        $this->command = $command;
    }

    /**
     *
     */
    function emit() : void
    {
        passthru($this->command);
    }
}
