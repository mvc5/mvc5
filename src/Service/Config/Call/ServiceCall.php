<?php
/**
 *
 */

namespace Mvc5\Service\Config\Call;

interface ServiceCall
{
    /**
     * @return array
     */
    function args();

    /**
     * @return string
     */
    function config();
}
