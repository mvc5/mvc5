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
 * Match types are based on https://github.com/klein/klein.php
 *
 * Variable regular expression is based on https://github.com/nikic/FastRoute
 */
trait Tokens
{
    /**
     * @var array
     */
    protected $expressions = [
        'a' => '[a-zA-Z0-9]++',
        'i' => '[0-9]++',
        'n' => '[a-zA-Z][a-zA-Z0-9]++',
        's' => '[a-zA-Z0-9_-]++',
        '*' => '.++',
        '*$' => '[a-zA-Z0-9/]+[a-zA-Z0-9]$'
    ];

    /**
     * @param $name
     * @param $constraint
     * @param array $constraints
     * @return mixed|string
     */
    protected function constraint($name, $constraint, array $constraints)
    {
        return $constraint ? $constraint : (isset($constraints[$name]) ? $constraints[$name] : '[^/]+');
    }

    /**
     * @param string $expr
     * @return mixed|string
     */
    protected function expression($expr)
    {
        return ':' === $expr[0] && isset($this->expressions[$n = substr($expr, 1)]) ? $this->expressions[$n] : $expr;
    }

    /**
     * @param string $route
     * @param array $constraints
     * @return array
     * @throws RuntimeException
     */
    protected function tokens($route, array $constraints = [])
    {
        $currentPos = 0;
        $length     = strlen($route);
        $level      = 0;
        $token      = '(\G(?P<literal>[^{}\[\]]*)(?P<token>[{}\[\]]|$))';
        $tokens     = [];
        $variable   = '(\G\s*(?P<name>[a-zA-Z][a-zA-Z0-9]*)?\s*(?(1):)?\s*(?P<constraint>[^{}]*(?:\{(?-1)\}[^{}]*)*)?)';

        while($currentPos < $length) {
            preg_match($token, $route, $match, 0, $currentPos);

            $currentPos += strlen($match[0]);

            '' !== $match['literal'] && $tokens[] = ['literal', $match['literal']];

            if ('{' === $match['token']) {
                preg_match($variable, $route, $match, 0, $currentPos);

                $currentPos += strlen($match[0]);

                $tokens[] = [
                    'param', $match['name'], $this->expression(
                        $this->constraint($match['name'], $match['constraint'], $constraints)
                    )
                ];

                continue;
            }

            if ('[' === $match['token']) {
                $tokens[] = ['optional-start'];
                $level++;
                continue;
            }

            if (']' === $match['token']) {
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
