<?php
/**
 *
 */

namespace Mvc5\Session;

use Mvc5\Arg;

interface SessionMessages
    extends \Serializable
{
    /**
     * @param $name
     * @return array
     */
    function message($name = '');

    /**
     * @param string $message
     * @param mixed|string $type
     * @param string $name
     * @return mixed
     */
    function flash($message, $type = Arg::INFO, $name = '');
}
