<?php
/**
 *
 */

namespace Mvc5\Route;

interface Error
    extends Route
{
    /**
     * @return mixed|Route
     */
    function route();
}
