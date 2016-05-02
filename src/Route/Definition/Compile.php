<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use InvalidArgumentException;

/**
 * Portions copyright (c) 2013 Ben Scholzen 'DASPRiD'. (http://github.com/DASPRiD/Dash)
 * under the Simplified BSD License (http://opensource.org/licenses/BSD-2-Clause).
 */
trait Compile
{
    /**
     * @param $tokens
     * @param $params
     * @param $defaults
     * @return mixed
     * @throws InvalidArgumentException
     */
    protected function compile($tokens, $params, $defaults)
    {
        $stack = [];

        $current = [
            'is_optional' => false,
            'skip'        => true,
            'skippable'   => false,
            'path'        => '',
        ];

        foreach($tokens as $part) {
            switch($part[Dash::TYPE]) {
                case 'literal':

                    $current['path'] .= $part[Dash::LITERAL];

                    break;

                case 'param':

                    $current['skippable'] = true;

                    if (!isset($params[$part[Dash::NAME]])) {

                        if (!$current['is_optional']) {
                            throw new InvalidArgumentException(sprintf('Missing parameter "%s"', $part[Dash::NAME]));
                        }

                        continue;
                    }

                    if (!$current['is_optional']
                            || !isset($defaults[$part[Dash::NAME]])
                                || $defaults[$part[Dash::NAME]] !== $params[$part[Dash::NAME]]) {
                        $current['skip'] = false;
                    }

                    $current['path'] .= $params[$part[Dash::NAME]];

                    break;

                case 'optional-start':

                    $stack[] = $current;

                    $current = [
                        'is_optional' => true,
                        'skip'        => true,
                        'skippable'   => false,
                        'path'        => '',
                    ];

                    break;

                case 'optional-end':

                    $parent = array_pop($stack);

                    if (!($current['path'] !== '' && $current['is_optional'] && $current['skippable'] && $current['skip'])) {
                        $parent['path'] .= $current['path'];
                        $parent['skip'] = false;
                    }

                    $current = $parent;

                    break;
            }
        }

        return $current['path'];
    }
}
