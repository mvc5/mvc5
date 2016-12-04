<?php
/**
 *
 */
namespace Mvc5\Response\Emitter;

use Mvc5\Response\Emitter;

class Callback
    implements Emitter
{
    /**
     * @var callable
     */
    protected $emitter;

    /**
     * @param callable $emitter
     */
    function __construct(callable $emitter)
    {
        $this->emitter = $emitter;
    }

    /**
     * @return mixed
     */
    function emit()
    {
       return ($this->emitter)();
    }
}
