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
     * @param \Throwable $exception
     * @return bool
     */
    function __invoke(\Throwable $exception)
    {
        return $this->signal($this->logger, [$exception]);
    }
}
