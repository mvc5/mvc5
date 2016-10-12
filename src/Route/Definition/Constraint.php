<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

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
            'param' === $token[Dash::TYPE] && $token[Dash::NAME] &&
                $constraint[$token[Dash::NAME]] = $token[Dash::CONSTRAINT];
        }

        return $constraint;
    }
}
