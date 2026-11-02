<?php
declare(strict_types=1);

namespace BehavioralPatterns\Iterator;

use Iterator;
use IteratorAggregate;
use Traversable;

final class StudentIterator implements Iterator
{
    private int $position = 0;

    public function __construct(private array $students)
    {
    }

    public function current(): mixed
    {
        return $this->students[$this->position];
    }

    public function key(): mixed
    {
        return $this->position;
    }

    public function next(): void
    {
        $this->position++;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return array_key_exists($this->position, $this->students);
    }
}

final class StudentCollection implements IteratorAggregate
{
    public function __construct(private array $students)
    {
    }

    public function getIterator(): Traversable
    {
        return new StudentIterator($this->students);
    }
}
