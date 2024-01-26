<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal;

use Symfony\Component\ExpressionLanguage\Node\Node;

/**
 * @internal A query compiler.
 */
final class QueryCompiler
{
    /**
     * Applies specified parameters to the query.
     *
     * @param string $query      Query string.
     * @param array  $parameters Query parameters.
     *
     * @throws \Exception
     */
    public function apply(string $query, array $parameters = []): string
    {
        $patterns     = [];
        $replacements = [];

        foreach ($parameters as $key => $value) {
            if (!is_scalar($value)) {
                throw new \Exception(sprintf('Parameter "%s" contains non-scalar value', $key));
            }

            if (is_string($value)) {
                $value = '"' . $value . '"';
            } elseif (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }

            $patterns[]     = '/(\s|\=|\<|\>|\~)(\:' . $key . ')([^A-Za-z_0-9]|$)/';
            $replacements[] = '${1}' . preg_quote($value) . '${3}';
        }

        return preg_replace($patterns, $replacements, $query);
    }

    /**
     * Compiles specified AST node of the query into Linode API filter.
     *
     * @return array Filters generated for the node.
     *
     * @throws \Exception
     */
    public function compile(Node $node): array
    {
        $operator = $node->attributes['operator'] ?? null;

        if (null === $operator) {
            throw new \Exception('Invalid expression');
        }

        switch ($operator) {
            case 'and':
                return ['+and' => [
                    $this->compile($node->nodes['left']),
                    $this->compile($node->nodes['right']),
                ]];

            case 'or':
                return ['+or' => [
                    $this->compile($node->nodes['left']),
                    $this->compile($node->nodes['right']),
                ]];

            case '==':
            case '!=':
            case '<':
            case '<=':
            case '>':
            case '>=':
            case '~':
                $name  = $node->nodes['left']->attributes['name']   ?? null;
                $value = $node->nodes['right']->attributes['value'] ?? null;

                if (null === $name) {
                    throw new \Exception(sprintf('Left operand for the "%s" operator must be a field name', $operator));
                }

                if (null === $value) {
                    throw new \Exception(sprintf('Right operand for the "%s" operator must be a constant value', $operator));
                }

                $operators = [
                    '!=' => '+neq',
                    '<'  => '+lt',
                    '<=' => '+lte',
                    '>'  => '+gt',
                    '>=' => '+gte',
                    '~'  => '+contains',
                ];

                return ('==' === $operator)
                    ? [$name => $value]
                    : [$name => [$operators[$operator] => $value]];

            default:
                throw new \Exception(sprintf('Unknown operator "%s"', $operator));
        }
    }
}
