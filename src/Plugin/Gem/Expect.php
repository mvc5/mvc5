<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

use Mvc5\Resolvable;

interface Expect
    extends Gem
{
    /**
     * @param \Throwable $exception
     * @param array $args
     * @return array
     */
    function args(\Throwable $exception, array $args) : array;

    /**
     * @return mixed
     */
    function exception();

    /**
     * @return Resolvable|mixed
     */
    function plugin();
}
