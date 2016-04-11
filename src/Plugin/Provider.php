<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Service\Scope;
use Mvc5\Service\Service as _Service;

class Provider
    extends Call
{
    /**
     * Constructor lists the class name, Plugins|Scope object, and additional constructor args
     * @param $config
     * @param array ...$args
     */
    public function __construct($config, ...$args)
    {
        parent::__construct([$this, 'provider'], [new Link, $config, new Args($args)]);
    }

    /**
     * @param _Service $service
     * @param $config
     * @param array $args
     * @return callable|null|object
     */
    public function provider(_Service $service, $config, array $args = [])
    {
        $plugin = $service->plugin($config, $args);

        $args && $args[0] instanceof Scope &&
            $args[0]->scope($plugin);

        return $plugin;
    }
}
