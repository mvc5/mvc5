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
    function danger($message, $name = Arg::INDEX);

    /**
     * @param array|string $message
     * @param string $name
     */
    function info($message, $name = Arg::INDEX);

    /**
     * @param string $name
     * @return array
     */
    function message($name = Arg::INDEX);

    /**
     * @param array|string $message
     * @param string $name
     */
    function success($message, $name = Arg::INDEX);

    /**
     * @param array|string $message
     * @param string $name
     */
    function warning($message, $name = Arg::INDEX);
}
