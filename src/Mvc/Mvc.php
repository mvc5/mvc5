<?php
/**
 *
 */

namespace Mvc5\Mvc;

use Mvc5\Arg;
use Mvc5\Response\Response;
use Mvc5\Route\Route;

trait Mvc
{
    /**
     *
     */
    use Event\Model;

    /**
     * @return array
     */
    protected function args()
    {
        return [
            Arg::EVENT      => $this,
            Arg::RESPONSE   => $this->response(),
            Arg::ROUTE      => $this->route(),
            Arg::MODEL      => $this->model(),
            Arg::CONTROLLER => $this->controller()
        ];
    }

    /**
     * @param callable $callable
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    public function __invoke(callable $callable, array $args = [], callable $callback = null)
    {
        $model = $this->signal($callable, $this->args() + $args, $callback);

        if ($model instanceof Route) {
            $this->setRoute($model);
            return $model;
        }

        if ($model instanceof Response) {
            $this->setResponse($model);
            return $model;
        }

        $model && $this->setModel($model);

        return $model;
    }
}
