<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use InvalidArgumentException;
use Mvc5\Arg;

/**
 * Portions copyright (c) 2013 Ben Scholzen 'DASPRiD'. (http://github.com/DASPRiD/Dash)
 * under the Simplified BSD License (http://opensource.org/licenses/BSD-2-Clause).
 */
trait Compile
{
    /**
     * @param array $tokens
     * @param array $params
     * @param array $defaults
     * @param bool|false $wildcard
     * @return string
     * @throws InvalidArgumentException
     */
    protected function compile(array $tokens, array $params, array $defaults = null, $wildcard = false)
    {
        $current = [
            'is_optional' => false,
            'skip'        => true,
            'skippable'   => false,
            'path'        => '',
        ];

        $stack = [];

        foreach($tokens as $part) {
            if ('literal' === $part[Dash::TYPE]) {
                $current['path'] .= $part[Dash::LITERAL];
                continue;
            }

            if ('param' === $part[Dash::TYPE]) {
                $current['skippable'] = true;

                if (!$part[Dash::NAME]) {
                    continue;
                }

                if (!isset($params[$part[Dash::NAME]])) {
                    if (!$current['is_optional']) {
                        throw new InvalidArgumentException(sprintf('Missing parameter "%s"', $part[Dash::NAME]));
                    }

                    continue;
                }

                (!$current['is_optional'] || !isset($defaults[$part[Dash::NAME]])
                    || $defaults[$part[Dash::NAME]] !== $params[$part[Dash::NAME]]) &&
                        $current['skip'] = false;

                $current['path'] .= $params[$part[Dash::NAME]];

                unset($params[$part[Dash::NAME]]);

                continue;
            }

            if ('optional-start' === $part[Dash::TYPE]) {

                $stack[] = $current;

                $current = [
                    'is_optional' => true,
                    'skip'        => true,
                    'skippable'   => false,
                    'path'        => '',
                ];

                continue;
            }

            if ('optional-end' === $part[Dash::TYPE]) {

                $parent = array_pop($stack);

                if ($current['path'] === '' || !$current['is_optional'] || !$current['skippable'] || !$current['skip']) {
                    $parent['path'] .= $current['path'];
                    $parent['skip'] = false;
                }

                $current = $parent;

                continue;
            }
        }

        if ($wildcard && $params) {
            $current['path'] = rtrim($current['path'], Arg::SEPARATOR);

            foreach($params as $key => $value) {
                null !== $value && $current['path'] .= Arg::SEPARATOR . $key . Arg::SEPARATOR . $value;
            }
        }

        return $current['path'];
    }
}
