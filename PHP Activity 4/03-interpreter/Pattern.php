<?php
declare(strict_types=1);

namespace BehavioralPatterns\Interpreter;

interface Expression
{
    public function interpret(array $student): bool;
}

final class TerminalExpression implements Expression
{
    public function __construct(
        private string $field,
        private string|int $expectedValue
    ) {
    }

    public function interpret(array $student): bool
    {
        $actualValue = $student[$this->field] ?? null;
        if (is_int($this->expectedValue)) {
            return is_numeric($actualValue) && (int) $actualValue === $this->expectedValue;
        }

        return is_string($actualValue)
            && strcasecmp($actualValue, $this->expectedValue) === 0;
    }
}

final class AndExpression implements Expression
{
    public function __construct(
        private Expression $left,
        private Expression $right
    ) {
    }

    public function interpret(array $student): bool
    {
        return $this->left->interpret($student) && $this->right->interpret($student);
    }
}

final class OrExpression implements Expression
{
    public function __construct(
        private Expression $left,
        private Expression $right
    ) {
    }

    public function interpret(array $student): bool
    {
        return $this->left->interpret($student) || $this->right->interpret($student);
    }
}

final class QueryParser
{
    private array $tokens = [];
    private int $position = 0;
    private const FIELDS = ['PROGRAM' => 'program', 'YEAR' => 'year'];

    public function parse(string $query): Expression
    {
        $this->tokens = $this->tokenize($query);
        $this->position = 0;
        $expression = $this->parseOr();

        if ($this->position !== count($this->tokens)) {
            throw new \InvalidArgumentException('Unexpected token in student query.');
        }

        return $expression;
    }

    private function tokenize(string $query): array
    {
        $tokens = [];
        $offset = 0;
        $length = strlen($query);
        $pattern = '/\G("[^"]*"|\'[^\']*\'|[A-Za-z_][A-Za-z0-9_]*|\d+|=|\(|\))/';

        while ($offset < $length) {
            if (preg_match('/\G\s+/', $query, $space, 0, $offset) === 1) {
                $offset += strlen($space[0]);
            }
            if ($offset >= $length) {
                break;
            }
            if (preg_match($pattern, $query, $match, 0, $offset) !== 1) {
                throw new \InvalidArgumentException('Invalid character in student query.');
            }

            $tokens[] = $match[1];
            $offset += strlen($match[0]);
        }

        if ($tokens === []) {
            throw new \InvalidArgumentException('The student query cannot be empty.');
        }

        return $tokens;
    }

    private function parseOr(): Expression
    {
        $expression = $this->parseAnd();
        while ($this->matchKeyword('OR')) {
            $expression = new OrExpression($expression, $this->parseAnd());
        }

        return $expression;
    }

    private function parseAnd(): Expression
    {
        $expression = $this->parsePrimary();
        while ($this->matchKeyword('AND')) {
            $expression = new AndExpression($expression, $this->parsePrimary());
        }

        return $expression;
    }

    private function parsePrimary(): Expression
    {
        if ($this->match('(')) {
            $expression = $this->parseOr();
            $this->expect(')');
            return $expression;
        }

        $fieldToken = $this->nextToken();
        $field = strtoupper($fieldToken);
        if (!isset(self::FIELDS[$field])) {
            throw new \InvalidArgumentException("Unsupported query field: {$fieldToken}");
        }

        $this->expect('=');
        $valueToken = $this->nextToken();
        if (preg_match('/^\d+$/', $valueToken) === 1) {
            $value = (int) $valueToken;
        } elseif (
            strlen($valueToken) >= 2
            && (($valueToken[0] === '"' && str_ends_with($valueToken, '"'))
                || ($valueToken[0] === "'" && str_ends_with($valueToken, "'")))
        ) {
            $value = substr($valueToken, 1, -1);
        } else {
            throw new \InvalidArgumentException('Query values must be quoted text or an integer.');
        }

        return new TerminalExpression(self::FIELDS[$field], $value);
    }

    private function matchKeyword(string $keyword): bool
    {
        if (
            isset($this->tokens[$this->position])
            && strtoupper($this->tokens[$this->position]) === $keyword
        ) {
            $this->position++;
            return true;
        }

        return false;
    }

    private function match(string $token): bool
    {
        if (($this->tokens[$this->position] ?? null) === $token) {
            $this->position++;
            return true;
        }

        return false;
    }

    private function expect(string $token): void
    {
        if (!$this->match($token)) {
            throw new \InvalidArgumentException("Expected '{$token}' in student query.");
        }
    }

    private function nextToken(): string
    {
        if (!isset($this->tokens[$this->position])) {
            throw new \InvalidArgumentException('The student query ended unexpectedly.');
        }

        return $this->tokens[$this->position++];
    }
}

final class StudentContext
{
    public function __construct(private array $students)
    {
    }

    public function search(string $query): array
    {
        $expression = (new QueryParser())->parse($query);
        return array_values(array_filter(
            $this->students,
            static fn (array $student): bool => $expression->interpret($student)
        ));
    }
}
