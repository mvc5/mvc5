<?php
/**
 *
 */

namespace Mvc5\View\Exception;

use Mvc5\View\Model\Base;
use Throwable;

class Model
    implements ExceptionModel
{
    /**
     *
     */
    use Base;

    /**
     * @param Throwable $exception
     * @return mixed
     */
    public function exception(Throwable $exception)
    {
        $this->set(self::EXCEPTION, $exception);
    }
}
