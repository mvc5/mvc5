<?php
/**
 *
 */

namespace Mvc5\Service\Provider;

use Mvc5\Event\Event;
use Mvc5\Service\Resolver\EventSignal;
use Mvc5\Service\Resolver\Resolvable;

class Provider
    implements Event, Locator
{
    /**
     *
     */
    use EventSignal;

    /**
     *
     */
    const EVENT = self::PROVIDER;

    /**
     * @return array
     */
    protected function args()
    {
        return [
            Args::EVENT => $this
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
        $result = $this->signal($callable, $this->args() + $args, $callback);

        !$result instanceof Resolvable && $this->stop();

        return $result;
    }
}
