<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;

class Form
    implements Gem\Child
{
    /**
     *
     */
    use Config\Child;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->config = [
            Arg::NAME   => $name,
            Arg::PARENT => Arg::FORM
        ];
    }
}
