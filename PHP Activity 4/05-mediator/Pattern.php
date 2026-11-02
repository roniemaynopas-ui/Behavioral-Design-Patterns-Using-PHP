<?php
declare(strict_types=1);

namespace BehavioralPatterns\Mediator;

interface ChatMediator
{
    public function register(Student $student): void;

    public function send(string $message, Student $sender): array;
}

final class Student
{
    public function __construct(
        private string $name,
        private ChatMediator $mediator
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function send(string $message): array
    {
        return $this->mediator->send($message, $this);
    }

    public function receive(string $message): string
    {
        return "{$this->name} receives:\n{$message}";
    }
}

final class ChatRoom implements ChatMediator
{
    private array $students = [];

    public function register(Student $student): void
    {
        $this->students[$student->name()] = $student;
    }

    public function send(string $message, Student $sender): array
    {
        $messages = ["{$sender->name()}: {$message}"];
        foreach ($this->students as $student) {
            if ($student !== $sender) {
                $messages[] = $student->receive($message);
            }
        }

        return $messages;
    }
}
