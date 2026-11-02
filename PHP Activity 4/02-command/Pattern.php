<?php
declare(strict_types=1);

namespace BehavioralPatterns\Command;

interface Command
{
    public function execute(): string;

    public function undo(): string;

    public function label(): string;
}

final class StudentSystem
{
    private bool $enrolled = false;
    private bool $loggedIn = true;
    private array $subjects = ['IT101', 'IT102'];

    public function enrollStudent(): string
    {
        $this->enrolled = true;
        return 'Student successfully enrolled.';
    }

    public function cancelEnrollment(): string
    {
        $this->enrolled = false;
        return 'Enrollment reversed.';
    }

    public function dropSubject(string $subject): string
    {
        $position = array_search($subject, $this->subjects, true);
        if ($position === false) {
            return "Subject {$subject} is not enrolled.";
        }

        array_splice($this->subjects, $position, 1);
        return "Subject {$subject} successfully dropped.";
    }

    public function addSubject(string $subject): string
    {
        if (!in_array($subject, $this->subjects, true)) {
            $this->subjects[] = $subject;
        }

        return "Subject {$subject} restored.";
    }

    public function printRegistration(): string
    {
        return 'Registration printed.';
    }

    public function logout(): string
    {
        $this->loggedIn = false;
        return 'Student successfully logged out.';
    }

    public function restoreLogin(): string
    {
        $this->loggedIn = true;
        return 'Student login restored.';
    }

    public function isEnrolled(): bool
    {
        return $this->enrolled;
    }

    public function isLoggedIn(): bool
    {
        return $this->loggedIn;
    }

    public function subjects(): array
    {
        return $this->subjects;
    }
}

final class EnrollStudentCommand implements Command
{
    public function __construct(private StudentSystem $system)
    {
    }

    public function execute(): string
    {
        return $this->system->enrollStudent();
    }

    public function undo(): string
    {
        return $this->system->cancelEnrollment();
    }

    public function label(): string
    {
        return 'Enroll Student';
    }
}

final class DropSubjectCommand implements Command
{
    public function __construct(
        private StudentSystem $system,
        private string $subject
    ) {
    }

    public function execute(): string
    {
        return $this->system->dropSubject($this->subject);
    }

    public function undo(): string
    {
        return $this->system->addSubject($this->subject);
    }

    public function label(): string
    {
        return 'Drop Subject';
    }
}

final class PrintRegistrationCommand implements Command
{
    public function __construct(private StudentSystem $system)
    {
    }

    public function execute(): string
    {
        return $this->system->printRegistration();
    }

    public function undo(): string
    {
        return 'A printed registration cannot be recalled.';
    }

    public function label(): string
    {
        return 'Print Registration';
    }
}

final class LogoutCommand implements Command
{
    public function __construct(private StudentSystem $system)
    {
    }

    public function execute(): string
    {
        return $this->system->logout();
    }

    public function undo(): string
    {
        return $this->system->restoreLogin();
    }

    public function label(): string
    {
        return 'Logout';
    }
}

final class CommandInvoker
{
    private array $history = [];

    public function execute(Command $command): array
    {
        $result = [
            "Executing: {$command->label()}",
            $command->execute(),
        ];

        $this->history[] = $command;
        return $result;
    }

    public function undoLast(): array
    {
        $command = array_pop($this->history);
        if ($command === null) {
            return ['Nothing to undo.'];
        }

        return ["Undoing: {$command->label()}", $command->undo()];
    }
}
