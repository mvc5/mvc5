<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use Mvc5\Exception;

use function array_pop;
use function rtrim;
use function sprintf;

use const Mvc5\{ SEPARATOR };
use const Mvc5\Route\Dash\{ LITERAL, NAME, TYPE };

/**
 * Portions copyright (c) 2013 Ben Scholzen 'DASPRiD'. (http://github.com/DASPRiD/Dash)
 * under the Simplified BSD License (http://opensource.org/licenses/BSD-2-Clause).
 */
final class Compiler
{
    /**
     * @param array $tokens
     * @param array $params
     * @param array $defaults
     * @param callable|null $wildcard
     * @return string
     * @throws \InvalidArgumentException|\Throwable
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
            if ('literal' === $part[TYPE]) {
                $current['path'] .= $part[LITERAL];
                continue;
            }

            if ('param' === $part[TYPE]) {
                $current['skippable'] = true;

                if (!$part[NAME]) {
                    continue;
                }

                $default = $defaults[$part[NAME]] ?? null;
                $path    = $params[$part[NAME]]   ?? null;

                if (!$path) {
                    if ($current['is_optional']) {
                        continue;
                    }

                    !$default && Exception::invalidArgument(sprintf('Missing parameter "%s"', $part[NAME]));

                    $path = $default;
                }

                (!$current['is_optional'] || !$default || $default !== $path)
                    && $current['skip'] = false;

                $current['path'] .= $path;

                unset($params[$part[NAME]]);

                continue;
            }

            if ('optional-start' === $part[TYPE]) {

                $stack[] = $current;

                $current = [
                    'is_optional' => true,
                    'skip'        => true,
                    'skippable'   => false,
                    'path'        => '',
                ];

                continue;
            }

            if ('optional-end' === $part[TYPE]) {

                $parent = array_pop($stack);

                if ($current['path'] === '' || !$current['is_optional'] || !$current['skippable'] || !$current['skip']) {
                    $parent['path'] .= $current['path'];
                    $parent['skip'] = false;
                }

                $current = $parent;

                continue;
            }
        }

        return $wildcard && $params ? $wildcard(rtrim($current['path'], SEPARATOR), $params) : $current['path'];
    }

    /**
     * @param array $tokens
     * @param array $params
     * @param array|null $defaults
     * @param callable|null $wildcard
     * @return string
     * @throws \InvalidArgumentException|\Throwable
     */
    function __invoke(array $tokens, array $params, array $defaults = null, callable $wildcard = null) : string
    {
        return $this->compile($tokens, $params, (array) $defaults, $wildcard);
    }
}
