<?php
declare(strict_types=1);

namespace BehavioralPatterns\ChainOfResponsibility;

final class StudentRequest
{
    public function __construct(public readonly string $type)
    {
    }
}

interface RequestHandler
{
    public function setNext(?RequestHandler $handler): void;

    public function handle(StudentRequest $request): array;
}

abstract class OfficeHandler implements RequestHandler
{
    private ?RequestHandler $next = null;

    public function __construct(
        private string $officeName,
        private array $handledTypes
    ) {
    }

    public function setNext(?RequestHandler $handler): void
    {
        $this->next = $handler;
    }

    public function handle(StudentRequest $request): array
    {
        if (in_array($request->type, $this->handledTypes, true)) {
            return ["{$this->officeName}: Processing {$request->type}..."];
        }

        $messages = ["{$this->officeName}: Cannot process request."];
        if ($this->next !== null) {
            return [...$messages, ...$this->next->handle($request)];
        }

        return [...$messages, 'Request could not be processed by any office.'];
    }
}

final class StudentAffairsHandler extends OfficeHandler
{
    public function __construct()
    {
        parent::__construct('Student Affairs', ['Certificate of Enrollment']);
    }
}

final class RegistrarHandler extends OfficeHandler
{
    public function __construct()
    {
        parent::__construct('Registrar', ['Transcript of Records']);
    }
}

final class FinanceHandler extends OfficeHandler
{
    public function __construct()
    {
        parent::__construct('Finance', ['Good Moral Certificate']);
    }
}

final class IctHandler extends OfficeHandler
{
    public function __construct()
    {
        parent::__construct('ICT', ['Student ID Concern']);
    }
}
