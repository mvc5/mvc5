<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use Mvc5\Arg;

/**
 * Portions copyright (c) 2013 Ben Scholzen 'DASPRiD'. (http://github.com/DASPRiD/Dash)
 * under the Simplified BSD License (http://opensource.org/licenses/BSD-2-Clause).
 */
trait Regex
{
    /**
     * @param array $tokens
     * @param array $constraints
     * @param string $delimiter
     * @return string
     */
    protected function regex(array $tokens, array $constraints = [], $delimiter = Arg::SEPARATOR)
    {
        $delimiter  = preg_quote($delimiter);
        $groupIndex = 1;
        $regex      = '';

        foreach($tokens as $token) {
            if ('literal' === $token[Dash::TYPE]) {
                $regex .= preg_quote($token[Dash::LITERAL]);
                continue;
            }

            if ('parameter' === $token[Dash::TYPE]) {
                $groupName = '?P<param' . $groupIndex++ . '>';

                if (isset($constraints[$token[Dash::NAME]])) {
                    $regex .= '(' . $groupName . $constraints[$token[Dash::NAME]] . ')';
                    continue;
                }

                if (null === $token[Dash::DELIMITERS]) {
                    $regex .= '(' . $groupName . '[^' . $delimiter . ']+)';
                    continue;
                }

                $regex .= '(' . $groupName . '[^' . $token[Dash::DELIMITERS] . ']+)';

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
