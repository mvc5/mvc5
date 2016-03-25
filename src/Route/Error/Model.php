<?php
/**
 *
 */

namespace Mvc5\Route\Error;

use Mvc5\Arg;
use Mvc5\Model\Plugin;
use Mvc5\Route\Error;

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
    public function code()
    {
        return $this[Arg::ERROR][Arg::CODE];
    }

    /**
     * @return array
     */
    public function errors()
    {
        return $this[Arg::ERROR][Arg::ERRORS];
    }

    /**
     * @return string
     */
    public function message()
    {
        return $this[Arg::ERROR][Arg::MESSAGE];
    }
}
