<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

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
     * @return \Mvc5\Resolvable|mixed
     */
    function exception();

    /**
     * @return \Mvc5\Resolvable|mixed
     */
    function plugin();
}
