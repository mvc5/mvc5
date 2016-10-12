<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

/**
 * Portions copyright (c) 2013 Ben Scholzen 'DASPRiD'. (http://github.com/DASPRiD/Dash)
 * under the Simplified BSD License (http://opensource.org/licenses/BSD-2-Clause).
 */
trait Regex
{
    /**
     * @param array $tokens
     * @return string
     */
    protected function regex(array $tokens)
    {
        $regex = '';

        foreach($tokens as $token) {
            if ('literal' === $token[Dash::TYPE]) {
                $regex .= preg_quote($token[Dash::LITERAL]);
                continue;
            }

            if ('param' === $token[Dash::TYPE]) {
                $regex .= $token[Dash::NAME] ?
                    '(?P<' . $token[Dash::NAME] . '>' . $token[Dash::CONSTRAINT] . ')' : $token[Dash::CONSTRAINT];
                continue;
            }

            if ('optional-start' === $token[Dash::TYPE]) {
                $regex .= '(?:';
                continue;
            }

            if ('optional-end' === $token[Dash::TYPE]) {
                $regex .= ')?';
                continue;
            }
        }

        return $regex;
    }
}
