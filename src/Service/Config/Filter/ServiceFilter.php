<?php
/**
 *
 */

namespace Mvc5\Service\Config\Filter;

interface ServiceFilter
{
    /**
     * @return string
     */
    function config();

    /**
     * @return string|array
     */
    function filter();
}
