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
    function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * @return int
     */
    function emit()
    {
        passthru($this->command, $return_var);
        return $return_var;
    }
}
