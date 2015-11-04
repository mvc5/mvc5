<?php
/**
 *
 */

namespace Mvc5\Route\Definition\Build;

use InvalidArgumentException;

/**
 * Portions copyright (c) 2013 Ben Scholzen 'DASPRiD'. (http://github.com/DASPRiD/Dash)
 * under the Simplified BSD License (http://opensource.org/licenses/BSD-2-Clause).
 */
trait Compile
{
    /**
     * @param $tokens
     * @param $args
     * @param $defaults
     * @return mixed
     * @throws InvalidArgumentException
     */
    protected function compile($tokens, $args, $defaults)
    {
        $stack = [];

        $current = [
            'is_optional' => false,
            'skip'        => true,
            'skippable'   => false,
            'path'        => '',
        ];

        foreach($tokens as $part) {
            switch($part[Args::TYPE]) {
                case 'literal':

                    $current['path'] .= $part[Args::LITERAL];

                    break;

                case 'parameter':

                    $current['skippable'] = true;

                    if (!isset($args[$part[Args::NAME]])) {

                        if (!$current['is_optional']) {
                            throw new InvalidArgumentException(sprintf('Missing parameter "%s"', $part[Args::NAME]));
                        }

                        continue;
                    }

                    if (!$current['is_optional']
                            || !isset($defaults[$part[Args::NAME]])
                                || $defaults[$part[Args::NAME]] !== $args[$part[Args::NAME]]) {
                        $current['skip'] = false;
                    }

                    $current['path'] .= $args[$part[Args::NAME]];

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
