<?php
/**
 *
 */

namespace Mvc5\Session;

use Mvc5\ArrayObject;

class Messages
    extends ArrayObject
    implements SessionMessages
{
    /**
     *
     */
    use Config\Messages;
}
