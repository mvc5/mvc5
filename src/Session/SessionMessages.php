<?php
/**
 *
 */

namespace Mvc5\Session;

use Mvc5\Arg;
use Mvc5\Config\Configuration;

interface SessionMessages
    extends Configuration, \Serializable
{
    /**
     * @param array|string $message
     * @param string $name
     */
    function danger($message, string $name = Arg::INDEX);

    /**
     * @param array|string $message
     * @param string $name
     */
    function info($message, string $name = Arg::INDEX);

    /**
     * @param string $name
     * @return array|null
     */
    function message(string $name = Arg::INDEX);

    /**
     * @param array|string $message
     * @param string $name
     */
    function success($message, string $name = Arg::INDEX);

    /**
     * @param array|string $message
     * @param string $name
     */
    function warning($message, string $name = Arg::INDEX);
}
