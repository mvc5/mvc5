<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use function preg_quote;

use const Mvc5\Route\Dash\{ CONSTRAINT, LITERAL, NAME, TYPE };

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
    protected function regex(array $tokens) : string
    {
        $regex = '';

        foreach($tokens as $token) {
            if ('literal' === $token[TYPE]) {
                $regex .= preg_quote($token[LITERAL]);
                continue;
            }

            if ('param' === $token[TYPE]) {
                $regex .= $token[NAME] ?
                    '(?P<' . $token[NAME] . '>' . $token[CONSTRAINT] . ')' : $token[CONSTRAINT];
                continue;
            }

            if ('optional-start' === $token[TYPE]) {
                $regex .= '(?:';
                continue;
            }

            if ('optional-end' === $token[TYPE]) {
                $regex .= ')?';
                continue;
            }
        }

        return $regex;
    }
}
