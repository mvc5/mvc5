<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use RuntimeException;

/**
 * Portions copyright (c) 2013 Ben Scholzen 'DASPRiD'. (http://github.com/DASPRiD/Dash)
 * under the Simplified BSD License (http://opensource.org/licenses/BSD-2-Clause).
 *
 * Variable regular expression is from https://github.com/nikic/FastRoute
 */
trait Tokens
{
    /**
     * @param string $route
     * @param array $constraints
     * @param array $expressions
     * @return array
     * @throws RuntimeException
     */
    protected function tokens($route, array $constraints = [], array $expressions = [])
    {
        $currentPos = 0;
        $length     = strlen($route);
        $level      = 0;
        $tokens     = [];
        $variable   = '(\G\s*(?P<name>[a-zA-Z][a-zA-Z0-9]*)?\s*(?(1):)?\s*(?P<expr>[^{}]*(?:\{(?-1)\}[^{}]*)*)?)';

        while($currentPos < $length) {
            preg_match('(\G(?P<literal>[^{}\[\]]*)(?P<token>[{}\[\]]|$))', $route, $matches, 0, $currentPos);

            $currentPos += strlen($matches[0]);

            !empty($matches['literal']) && $tokens[] = ['literal', $matches['literal']];

            if ('{' === $matches['token']) {
                preg_match($variable, $route, $matches, 0, $currentPos);

                $currentPos += strlen($matches[0]);

                $constraint = '' !== $matches['expr'] ? $matches['expr'] : (
                    isset($constraints[$matches['name']]) ? $constraints[$matches['name']] : '[^/]+'
                );

                ':' === $constraint[0] && isset($expressions[$n = substr($constraint, 1)]) &&
                    $constraint = $expressions[$n];

                $tokens[] = ['param', $matches['name'], $constraint];

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
