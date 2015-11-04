<?php
/**
 *
 */

namespace Mvc5\Service\Config\ControllerAction;

use Mvc5\Service\Config\Base;
use Mvc5\Service\Resolver\Resolvable;

class ControllerAction
    implements Resolvable, ControllerService
{
    /**
     *
     */
    use Base;

    /**
     * @param array $args
     */
    public function __construct(array $args = [])
    {
        $this->config = [
            self::ARGS => [$args],
            self::NAME => self::CONTROLLER_ACTION
        ];
    }
}
