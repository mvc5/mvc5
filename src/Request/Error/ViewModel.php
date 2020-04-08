<?php
/**
 *
 */

namespace Mvc5\Request\Error;

use Mvc5\Http\Error;

use const Mvc5\ERROR;

final class ViewModel
    extends \Mvc5\ViewModel
    implements ErrorModel
{
    /**
     *
     */
    use Config\ErrorModel;

    /**
     *
     */
    const TEMPLATE = 'error';

    /**
     * @param Error $error
     * @param string $template
     */
    function __construct(Error $error, string $template = null)
    {
        parent::__construct($template, [ERROR => $error]);
    }
}
