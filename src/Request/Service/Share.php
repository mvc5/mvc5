<?php
/**
 *
 */

namespace Mvc5\Request\Service;

use ArrayAccess;
use Mvc5\Arg;
use Mvc5\Http\Request;

final class Share
{
    /**
     * @var ArrayAccess
     */
    protected ArrayAccess $container;

    /**
     * @param ArrayAccess $container
     */
    function __construct(ArrayAccess $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @return Request
     */
    function __invoke(Request $request) : Request
    {
        return $this->container[Arg::REQUEST] = $request;
    }
}
