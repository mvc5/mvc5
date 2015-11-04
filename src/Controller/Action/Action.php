<?php
/**
 *
 */

namespace Mvc5\Controller\Action;

use Iterator;
use Mvc5\Config\Base as Config;
use Mvc5\Config\Configuration;
use Mvc5\Event\Base;
use Mvc5\Event\Event;
use Mvc5\Response\Response;
use Mvc5\Service\Resolver\Signal;
use Mvc5\View\ViewModel as Model;
use Mvc5\View\Model\ViewModel;

class Action
    implements Configuration, Controller, Event, Iterator
{
    /**
     *
     */
    use Base;
    use Config;
    use Model;
    use Signal;

    /**
     * @return array
     */
    protected function args()
    {
        return [
            Args::EVENT => $this,
            Args::MODEL => $this->model()
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
        $response = $this->signal($callable, $this->args() + $args, $callback);

        $response instanceof ViewModel && $this->setModel($response);

        $response instanceof Response && $this->stop();

        return $response;
    }
}
