<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use Mvc5\Arg;
use RuntimeException;

/**
 * Portions copyright (c) 2013 Ben Scholzen 'DASPRiD'. (http://github.com/DASPRiD/Dash)
 * under the Simplified BSD License (http://opensource.org/licenses/BSD-2-Clause).
 *
 * Portions copyright (c) 2013 Nikita Popov 'nikic'. (https://github.com/nikic/FastRoute)
 * under the BSD 3-Clause License (https://opensource.org/licenses/BSD-3-Clause).
 */
trait Tokens
{
    /**
     * @param string $route
     * @param array $constraints
     * @param string $delimiter
     * @return array
     * @throws RuntimeException
     */
    protected function tokens($route, array $constraints = [], $delimiter = Arg::SEPARATOR)
    {
        $currentPos = 0;
        $delimiter  = preg_quote($delimiter);
        $length     = strlen($route);
        $level      = 0;
        $variable   = '(\G\s*(?P<name>[a-zA-Z][a-zA-Z0-9]*)?\s*(?::\s*(?P<expr>[^{}]*(?:\{(?-1)\}[^{}]*)*))?)';
        $tokens     = [];

        while($currentPos < $length) {
            preg_match('(\G(?P<literal>[^{}\[\]]*)(?P<token>[{}\[\]]|$))', $route, $matches, 0, $currentPos);

            $currentPos += strlen($matches[0]);

            !empty($matches['literal']) && $tokens[] = ['literal', $matches['literal']];

            if ('{' === $matches['token']) {
                preg_match($variable, $route, $matches, 0, $currentPos);

                $currentPos += strlen($matches[0]);

                $tokens[] = [
                    'param',
                    $matches['name'],
                    !empty($matches['expr']) ? $matches['expr'] : (
                        isset($constraints[$matches['name']]) ? $constraints[$matches['name']] : '[^' . $delimiter . ']+'
                    )
                ];

                continue;
            }

            if ('[' === $matches['token']) {
                $tokens[] = ['optional-start'];
                $level++;
                continue;
            }

            if (']' === $matches['token']) {
                $tokens[] = ['optional-end'];

                $level--;

                if ($level < 0) {
                    throw new RuntimeException('Found closing bracket without matching opening bracket');
                }
                continue;
            }
        }

        if ($level > 0) {
            throw new RuntimeException('Found unbalanced brackets');
        }

        return $tokens;
    }
}
