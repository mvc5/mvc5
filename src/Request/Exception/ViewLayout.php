<?php
/**
 *
 */

namespace Mvc5\Request\Exception;

use Throwable;

use const Mvc5\EXCEPTION;

final class ViewLayout
    extends \Mvc5\ViewLayout
    implements ExceptionLayout
{
    /**
     *
     */
    use Config\ExceptionLayout;

    /**
     *
     */
    const TEMPLATE = EXCEPTION;

    /**
     * @param Throwable $exception
     * @param string $template
     */
    function __construct(Throwable $exception, string $template = null)
    {
        parent::__construct($template, [EXCEPTION => $exception]);
    }
}
