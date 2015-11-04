<?php
/**
 *
 */

namespace Mvc5\Route\Definition\Build;

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
    protected function regex(array $tokens, array $constraints = [], $delimiter = '/')
    {
        $delimiter  = preg_quote($delimiter);
        $groupIndex = 1;
        $regex      = '';

        foreach($tokens as $token) {
            if ('literal' === $token[Args::TYPE]) {
                $regex .= preg_quote($token[Args::LITERAL]);
                continue;
            }

            if ('parameter' === $token[Args::TYPE]) {
                $groupName = '?P<param' . $groupIndex++ . '>';

                if (isset($constraints[$token[Args::NAME]])) {
                    $regex .= '(' . $groupName . $constraints[$token[Args::NAME]] . ')';
                    continue;
                }

                if (null === $token[Args::DELIMITERS]) {
                    $regex .= '(' . $groupName . '[^' . $delimiter . ']+)';
                    continue;
                }

                $regex .= '(' . $groupName . '[^' . $token[Args::DELIMITERS] . ']+)';

                continue;
            }

            if ('optional-start' === $token[Args::TYPE]) {
                $regex .= '(?:';
                continue;
            }

            if ('optional-end' === $token[Args::TYPE]) {
                $regex .= ')?';
                continue;
            }
        }

        return $regex;
    }
}
