<?php
/**
 *
 */

namespace Mvc5\Service\Resolver;

interface Args
{
    /**
     *
     */
    const ARGS = 'args';

    /**
     *
     */
    const CALL = '@';

    /**
     *
     */
    const CALL_SEPARATOR = '.';

    /**
     *
     */
    const EVENT_CREATE = 'event:create';

    /**
     *
     */
    const INDEX = '#';

    /**
     *
     */
    const NAME = 'name';

    /**
     *
     */
    const PROVIDER = 'service:provider';

    /**
     *
     */
    const SERVICE = 'service';

    /**
     *
     */
    const SERVICE_SEPARATOR = '->';

    /**
     *
     */
    const PROPERTY = '$';
}
