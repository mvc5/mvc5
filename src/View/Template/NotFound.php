<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Exception\Runtime;
use Mvc5\Model\Template;

class NotFound
    extends Runtime
{
    /**
     * @param $file
     * @throws \RuntimeException
     */
    final static function file($file)
    {
        throw new static('File not found: ' . $file, 0, null, debug_backtrace(0, 1)[0]);
    }

    /**
     * @param Template $template
     * @throws \RuntimeException
     */
    final static function missing(Template $template)
    {
        throw new static('Template name cannot be empty: ' . get_class($template), 0, null, debug_backtrace(0, 1)[0]);
    }
}
