<?php
declare(strict_types=1);

namespace BehavioralPatterns\Memento;

final class StudentProfileMemento
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $program
    ) {
    }
}

final class StudentProfile
{
    public function __construct(
        private string $name,
        private string $email,
        private string $program
    ) {
    }

    public function update(string $name, string $email, string $program): void
    {
        $this->name = $name;
        $this->email = $email;
        $this->program = $program;
    }

    public function createMemento(): StudentProfileMemento
    {
        return new StudentProfileMemento($this->name, $this->email, $this->program);
    }

    public function restore(StudentProfileMemento $memento): void
    {
        $this->name = $memento->name;
        $this->email = $memento->email;
        $this->program = $memento->program;
    }

    public function details(): string
    {
        return "{$this->name} | {$this->email} | {$this->program}";
    }
}

final class ProfileHistory
{
    private array $snapshots = [];

    public function save(StudentProfile $profile): void
    {
        $this->snapshots[] = $profile->createMemento();
    }

    public function undo(StudentProfile $profile): bool
    {
        $snapshot = array_pop($this->snapshots);
        if ($snapshot === null) {
            return false;
        }

        $profile->restore($snapshot);
        return true;
    }
}
