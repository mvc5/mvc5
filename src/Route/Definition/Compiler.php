<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use Mvc5\Arg;
use Mvc5\Exception;

/**
 * Portions copyright (c) 2013 Ben Scholzen 'DASPRiD'. (http://github.com/DASPRiD/Dash)
 * under the Simplified BSD License (http://opensource.org/licenses/BSD-2-Clause).
 */
class Compiler
{
    /**
     * @param array $tokens
     * @param array $params
     * @param array $defaults
     * @param callable|null $wildcard
     * @return string
     * @throws \InvalidArgumentException
     */
    static function compile(array $tokens, array &$params, array $defaults = [], callable $wildcard = null) : string
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

                $default = $defaults[$part[Dash::NAME]] ?? null;
                $path    = $params[$part[Dash::NAME]]   ?? null;

                if (!$path) {
                    if ($current['is_optional']) {
                        continue;
                    }

                    !$default && Exception::invalidArgument(sprintf('Missing parameter "%s"', $part[Dash::NAME]));

                    $path = $default;
                }

                (!$current['is_optional'] || !$default || $default !== $path)
                    && $current['skip'] = false;

                $current['path'] .= $path;

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

        return $wildcard && $params ? $wildcard(rtrim($current['path'], Arg::SEPARATOR), $params) : $current['path'];
    }

    /**
     * @param array $tokens
     * @param array $params
     * @param array|null $defaults
     * @param callable|null $wildcard
     * @return string
     * @throws \InvalidArgumentException
     */
    function __invoke(array $tokens, array $params, array $defaults = null, callable $wildcard = null) : string
    {
        return $this->compile($tokens, $params, (array) $defaults, $wildcard);
    }
}
