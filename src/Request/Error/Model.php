<?php
/**
 *
 */

namespace Mvc5\Request\Error;

use Mvc5\Arg;
use Mvc5\Model\Plugin;

class Model
    implements ViewModel
{
    /**
     *
     */
    use Plugin;

    /**
     *
     */
    const TEMPLATE_NAME = 'error/error';

    /**
     * @return int
     */
    function code()
    {
        return $this[Arg::ERROR][Arg::CODE];
    }

    /**
     * @return array
     */
    function errors()
    {
        return $this[Arg::ERROR][Arg::ERRORS];
    }

    /**
     * @return string
     */
    function message()
    {
        return $this[Arg::ERROR][Arg::MESSAGE];
    }
}
