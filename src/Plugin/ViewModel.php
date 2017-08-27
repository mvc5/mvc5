<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;

class ViewModel
    extends Plugin
{
    /**
     * @param array|string $template
     * @param array $vars
     * @param array $calls
     */
    function __construct($template, array $vars = [], array $calls = [])
    {
        parent::__construct(\Mvc5\ViewModel::class, [Arg::TEMPLATE => $template, Arg::VARS => $vars], $calls);
    }
}
