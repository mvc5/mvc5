<?php
/**
 *
 */

namespace Mvc5\Session;

use Mvc5\Config\Configuration;

interface SessionMessages
    extends Configuration, \Serializable
{
    /**
     * @param array|string $message
     * @param string|null $name
     */
    function danger($message, string $name = null);

    /**
     * @param array|string $message
     * @param string|null $name
     */
    function info($message, string $name = null);

    /**
     * @param string|null $name
     * @return array|null
     */
    function message(string $name = null);

    /**
     * @param array|string $message
     * @param string|null $name
     */
    function success($message, string $name = null);

    /**
     * @param array|string $message
     * @param string|null $name
     */
    function warning($message, string $name = null);
}
