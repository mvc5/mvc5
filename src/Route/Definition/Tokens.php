<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use Mvc5\Exception;

use function preg_match;
use function strlen;
use function substr;

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
    protected array $expressions = [
        'a' => '[a-zA-Z0-9]++',
        'i' => '[0-9]++',
        'n' => '[a-zA-Z][a-zA-Z0-9]++',
        's' => '[a-zA-Z0-9_-]++',
        '*' => '.++',
        '*$' => '[a-zA-Z0-9/]+[a-zA-Z0-9]$'
    ];

    /**
     * @param string $name
     * @param string $constraint
     * @param array $constraints
     * @return string
     */
    protected function constraint(string $name, string $constraint, array $constraints) : string
    {
        return $constraint ? $constraint : ($constraints[$name] ?? '[^/]+');
    }

    /**
     * @param string $expr
     * @return string
     */
    protected function expression(string $expr) : string
    {
        return ':' === $expr[0] && isset($this->expressions[$n = substr($expr, 1)]) ? $this->expressions[$n] : $expr;
    }

    /**
     * @param string $path
     * @param array $constraints
     * @return array
     * @throws \RuntimeException|\Throwable
     */
    protected function tokens(string $path, array $constraints = []) : array
    {
        $currentPos = 0;
        $length     = strlen($path);
        $level      = 0;
        $token      = '(\G(?P<literal>[^{}\[\]]*)(?P<token>[{}\[\]]|$))';
        $tokens     = [];
        $variable   = '(\G\s*(?P<name>[a-zA-Z0-9_]++)?\s*(?(1):)?\s*(?P<constraint>[^{}]*(?:\{(?-1)\}[^{}]*)*)?)';

        while($currentPos < $length) {
            preg_match($token, $path, $match, 0, $currentPos);

            $currentPos += strlen($match[0]);

            '' !== $match['literal'] && $tokens[] = ['literal', $match['literal']];

            if ('{' === $match['token']) {
                preg_match($variable, $path, $match, 0, $currentPos);

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

                (--$level < 0) && Exception::runtime('Found closing bracket without matching opening bracket');

                continue;
            }
        }

        ($level > 0) && Exception::runtime('Found unbalanced brackets');

        return $tokens;
    }
}
