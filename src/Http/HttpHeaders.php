<?php
/**
 *
 */

namespace Mvc5\Http;

use Mvc5\Model;

class HttpHeaders
    extends Model
    implements Headers
{
    /**
     *
     */
    use Config\Headers {
        remove as protected;
        set as protected;
    }
}
