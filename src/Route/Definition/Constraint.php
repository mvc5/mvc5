<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use Mvc5\Arg;

trait Constraint
{
    /**
     * @param array $tokens
     * @param array $constraint
     * @return array
     */
    protected function constraint(array $tokens, array $constraint = [])
    {
        foreach($tokens as $token) {
            Arg::PARAM === $token[Dash::TYPE] && $token[Dash::NAME] &&
                $constraint[$token[Dash::NAME]] = $token[Dash::CONSTRAINT];
        }

        return $constraint;
    }
}
