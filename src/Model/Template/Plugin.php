<?php
/**
 *
 */

namespace Mvc5\Model\Template;

use Mvc5\Plugin as Base;

trait Plugin
{
    /**
     *
     */
    use Base;

    /**
     * @param string $name
     * @param array $args
     * @return mixed
     */
    public function __call($name, array $args = [])
    {
        return $this->call($name, $args);
    }
}
