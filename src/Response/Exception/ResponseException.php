<?php
/**
 *
 */

namespace Mvc5\Response\Exception;

interface ResponseException
{
    /**
     *
     */
    const EXCEPTION = 'Response\Exception';

    /**
     * @param callable $callable
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null);
}
