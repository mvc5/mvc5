<?php
/**
 *
 */

namespace Mvc5\Log;

use Mvc5\Signal;

class Exception
{
    /**
     *
     */
    use Signal;

    /**
     * @var callable
     */
    protected $logger;

    /**
     * @param callable $logger
     */
    function __construct(callable $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param \Exception $exception
     * @return mixed
     */
    function __invoke(\Exception $exception)
    {
        $this->signal($this->logger, [$exception]);
    }
}
