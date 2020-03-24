<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Resolvable;
use Throwable;

use const Mvc5\EXCEPTION;

final class Expect
    implements Gem\Expect
{
    /**
     * @var bool
     */
    protected bool $args = false;

    /**
     * @var Resolvable
     */
    protected Resolvable $exception;

    /**
     * @var bool
     */
    protected bool $named = false;

    /**
     * @var Resolvable
     */
    protected Resolvable $plugin;

    /**
     * @param Resolvable|mixed $plugin
     * @param Resolvable|mixed|null $exception
     * @param bool|false $named
     * @param bool|false $args
     */
    function __construct($plugin, $exception = null, bool $named = false, bool $args = false)
    {
        $this->args = $args;
        $this->exception = $exception instanceof Resolvable ? $exception : new Value($exception);
        $this->named = $named;
        $this->plugin = $plugin instanceof Resolvable ? $plugin : new Value($plugin);
    }

    /**
     * @param Throwable $exception
     * @param array $args
     * @return array
     */
    function args(Throwable $exception, array $args = []) : array
    {
        return  $this->named ? $this->named($exception, $args) : $this->params($exception, $args);
    }

    /**
     * @return Resolvable
     */
    function exception() : Resolvable
    {
        return $this->exception;
    }

    /**
     * @param Throwable $exception
     * @param array $args
     * @return array
     */
    protected function named(Throwable $exception, array $args) : array
    {
        return [EXCEPTION => $exception] + ($this->args ? $args : []);
    }

    /**
     * @param Throwable $exception
     * @param array $args
     * @return array
     */
    protected function params(Throwable $exception, array $args) : array
    {
        return $this->args ? [$exception, ...$args] : [$exception];
    }

    /**
     * @return Resolvable
     */
    function plugin() : Resolvable
    {
        return $this->plugin;
    }
}
