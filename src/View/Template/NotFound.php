<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Exception\Base;
use Mvc5\Exception\Throwable;
use Mvc5\Model\Template;

class NotFound
    extends \RuntimeException
    implements Throwable
{
    /**
     *
     */
    use Base;

    /**
     * @param $file
     * @return mixed
     * @throws self
     */
    static function file($file)
    {
        return static::raise(static::create(static::class, 'File not found: ' . $file));
    }

    /**
     * @param Template $template
     * @return mixed
     * @throws self
     */
    static function missing(Template $template)
    {
        return static::raise(static::create(static::class, 'Template name cannot be empty: ' . get_class($template)));
    }
}
