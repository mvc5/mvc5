<?php
/**
 *
 */

namespace Mvc5\Http\Uri;

use Mvc5\Http\Config\Uri;
use Mvc5\Model;

class Config
    extends Model
    implements \Mvc5\Http\Uri
{
    /**
     *
     */
    use Uri;

    /**
     * @param array|string|mixed $config
     */
    function __construct($config = [])
    {
        $this->config = is_array($config) ? $config : parse_url((string) $config);
    }
}
