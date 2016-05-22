<?php
/**
 *
 */

namespace Mvc5;

class Mvc
    implements Event\Event
{
    /**
     *
     */
    use Event\Signal;

    /**
     * @var array|\ArrayAccess
     */
    protected $config;

    /**
     * @var
     */
    protected $model;

    /**
     * @param string $event
     * @param array|\ArrayAccess $config
     */
    function __construct($event, $config)
    {
        $this->config = $config;
        $this->event  = $event;
    }

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
        ]);
    }

    /**
     * @param $model
     * @return array|callable|null|object|string
     */
    protected function model($model = null)
    {
        return func_num_args() ? $this->model = $model : $this->model;
    }

    /**
     * @param Http\Request $request
     * @return Http\Request
     */
    protected function request(Http\Request $request = null)
    {
        return null !== $request ? $this->config[Arg::REQUEST] = $request : $this->config[Arg::REQUEST];
    }

    /**
     * @param Http\Response $response
     * @return Http\Response
     */
    protected function response(Http\Response $response = null)
    {
        return null !== $response ? $this->config[Arg::RESPONSE] = $response : $this->config[Arg::RESPONSE];
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

        if ($model instanceof Http\Response) {
            return $this->response($model);
        }

        if ($model instanceof Http\Request) {
            return $this->request($model);
        }

        null !== $model
            && $this->model($model);

        return $model;
    }
}
