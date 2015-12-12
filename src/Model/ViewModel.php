<?php
/**
 *
 */

namespace Mvc5\Model;

use Mvc5\Service;

interface ViewModel
    extends Template, Service
{
    /**
     * @param $name
     * @param array $args
     * @return mixed
     */
    function __call($name, array $args = []);
}
