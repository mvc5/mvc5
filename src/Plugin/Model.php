<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;
use Mvc5\Model as Mvc5Model;

class Model
    implements Gem\Plugin
{
    /**
     *
     */
    use Config\Plugin;

    /**
     * @param $template
     * @param array $args
     * @param array $calls
     */
    public function __construct($template, array $args = [], array $calls = [])
    {
        $this->config = [
            Arg::ARGS  => [Arg::TEMPLATE => $template, Arg::CONFIG => $args],
            Arg::CALLS => $calls,
            Arg::NAME  => Mvc5Model::class
        ];
    }
}
