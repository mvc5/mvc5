<?php
/**
 *
 */

namespace Mvc5\Service;

interface Manager
    extends Container, Service
{
    /**
     * @return array|mixed
     */
    function config();

    /**
     * @return array|mixed
     */
    function container();

    /**
     * @return array|mixed
     */
    function events();

    /**
     * @return array|mixed
     */
    function services();
}
