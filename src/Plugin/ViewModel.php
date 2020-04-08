<?php
/**
 *
 */

namespace Mvc5\Plugin;

use const Mvc5\{ TEMPLATE, VARS };

final class ViewModel
    extends Plugin
{
    /**
     * @param array|string $template
     * @param array $vars
     * @param array $calls
     */
    function __construct($template, array $vars = [], array $calls = [])
    {
        parent::__construct(\Mvc5\ViewModel::class, [TEMPLATE => $template, VARS => $vars], $calls);
    }
}
