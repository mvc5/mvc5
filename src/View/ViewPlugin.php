<?php
/**
 *
 */

namespace Mvc5\View;

use Mvc5\View\Manager\ManageView;

trait ViewPlugin
{
    /**
     *
     */
    use ManageView;

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
