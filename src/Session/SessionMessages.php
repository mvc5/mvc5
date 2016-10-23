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
     * @param $name
     * @return array
     */
    function message($name = Arg::INDEX);

    /**
     * @param string $message
     * @param mixed|string $type
     * @param string $name
     * @return mixed
     */
    function add($message, $type = Arg::INFO, $name = Arg::INDEX);
}
