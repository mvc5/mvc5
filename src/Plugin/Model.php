<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;
use Mvc5\Model as Mvc5Model;

class Model
    extends Plugin
{
    /**
     * @param $template
     * @param array $args
     * @param array $calls
     */
    function __construct($template, array $args = [], array $calls = [])
    {
        parent::__construct(Mvc5Model::class, [Arg::TEMPLATE => $template, Arg::CONFIG => $args], $calls);
    }
}
