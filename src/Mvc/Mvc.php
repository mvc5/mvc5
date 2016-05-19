<?php
/**
 *
 */

namespace Mvc5\Mvc;

use Mvc5\Arg;
use Mvc5\Http\Response as HttpResponse;
use Mvc5\Http\Request as HttpRequest;

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
        return array_filter([
            Arg::EVENT      => $this,
            Arg::RESPONSE   => $this->response(),
            Arg::REQUEST    => $this->request(),
            Arg::MODEL      => $this->model(),
            Arg::CONTROLLER => $this->controller()
        ]);
    }

    /**
     * @param callable $callable
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null)
    {
        $model = $this->signal($callable, $this->args() + $args, $callback);

        if ($model instanceof HttpResponse) {
            $model !== $this->response() &&
                $this->stop();

            return $this->response($model);
        }

        if ($model instanceof HttpRequest) {
            return $this->request($model);
        }

        $model && $this->model($model);

        return $model;
    }
}
