<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;
use Mvc5\ViewModel as _ViewModel;

class ViewModel
    extends Plugin
{
    /**
     * @param $template
     * @param array $vars
     * @param array $calls
     */
    function __construct($template, array $vars = [], array $calls = [])
    {
        parent::__construct(_ViewModel::class, [Arg::TEMPLATE => $template, Arg::VARS => $vars], $calls);
    }
}
