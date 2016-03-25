<?php
/**
 *
 */

namespace Mvc5\Response\Error;

use Mvc5\Arg;
use Mvc5\Response\Error;

class MethodNotAllowed
    implements Error
{
    /**
     *
     */
    use Config;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config + [
                Arg::DESCRIPTION => 'Unsupported resource request method',
                Arg::ERRORS      => [],
                Arg::MESSAGE     => 'Method Not Allowed',
                Arg::STATUS      => '405'
        ];
    }
}
