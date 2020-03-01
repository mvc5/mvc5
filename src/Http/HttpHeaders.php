<?php
/**
 *
 */

namespace Mvc5\Http;

use Mvc5\ArrayModel;

class HttpHeaders
    extends ArrayModel
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
