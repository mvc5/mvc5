<?php
/**
 *
 */
namespace Mvc5\Response\Emitter;

use Mvc5\Response\Emitter;
use Mvc5\Signal;

class Callback
    implements Emitter
{
    /**
     *
     */
    use Signal;

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
       return $this->signal($this->emitter);
    }
}
