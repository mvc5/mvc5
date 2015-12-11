<?php
/**
 *
 */

namespace Mvc5\View;

use Mvc5\Arg;
use Throwable;

trait Renderer
{
    /**
     * @param array|callable|object|string $name
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    protected abstract function call($name, array $args = [], callable $callback = null);

    /**
     * @param Throwable $exception
     * @param $model
     * @return mixed
     */
    protected function exception(Throwable $exception, $model)
    {
        return $this->call(Arg::VIEW_EXCEPTION, [Arg::EXCEPTION => $exception, Arg::MODEL => $model]);
    }

    /**
     * @param $model
     * @param array $args
     * @return mixed
     */
    protected function render($model, array $args = [])
    {
        return $this->call(Arg::VIEW_RENDER, [Arg::MODEL => $model] + $args);
    }
}
