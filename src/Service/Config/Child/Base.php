<?php
/**
 *
 */

namespace Mvc5\Service\Config\Child;

use Mvc5\Service\Config\Base as BaseConfig;

trait Base
{
    /**
     *
     */
    use BaseConfig;

    /**
     * @return string
     */
    public function parent()
    {
        return $this->get(ChildService::PARENT);
    }
}
