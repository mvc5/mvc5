<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;
use Mvc5\Resolvable;

use function array_merge;

final class Expect
    implements Gem\Expect
{
    /**
     * @var bool
     */
    protected bool $args = false;

    /**
     * @var mixed|null
     */
    protected $exception;

    /**
     * @var bool
     */
    protected bool $named = false;

    /**
     * @var Resolvable|mixed
     */
    protected $plugin;

    /**
     * @param Resolvable|mixed $plugin
     * @param mixed|null $exception
     * @param bool|false $named
     * @param bool|false $args
     */
    function __construct($plugin, $exception = null, bool $named = false, bool $args = false)
    {
        $this->args = $args;
        $this->exception = $exception;
        $this->named = $named;
        $this->plugin = $plugin;
    }

    /**
     * @param \Throwable $exception
     * @param array $args
     * @return array
     */
    function args(\Throwable $exception, array $args = []) : array
    {
        return  $this->named ? $this->named($exception, $args) : $this->params($exception, $args);
    }

    /**
     * @return \Mvc5\Resolvable|mixed
     */
    function exception()
    {
        return $this->exception;
    }

    /**
     * @param \Throwable $exception
     * @param array $args
     * @return array
     */
    protected function named(\Throwable $exception, array $args) : array
    {
        return [Arg::EXCEPTION => $exception] + ($this->args ? $args : []);
    }

    /**
     * @param \Throwable $exception
     * @param array $args
     * @return array
     */
    protected function params(\Throwable $exception, array $args) : array
    {
        return $this->args ? array_merge([$exception], $args) : [$exception];
    }

    /**
     * @return \Mvc5\Resolvable|mixed
     */
    function plugin()
    {
        return $this->plugin;
    }
}
