<?php
declare(strict_types=1);

namespace BehavioralPatterns\State;

use LogicException;

interface EnrollmentState
{
    public function name(): string;

    public function submit(EnrollmentApplication $application): string;

    public function approve(EnrollmentApplication $application): string;

    public function reject(EnrollmentApplication $application): string;
}

abstract class AbstractEnrollmentState implements EnrollmentState
{
    public function submit(EnrollmentApplication $application): string
    {
        throw new LogicException("Cannot submit while application is {$this->name()}.");
    }

    public function approve(EnrollmentApplication $application): string
    {
        throw new LogicException("Cannot approve while application is {$this->name()}.");
    }

    public function reject(EnrollmentApplication $application): string
    {
        throw new LogicException("Cannot reject while application is {$this->name()}.");
    }
}

final class DraftState extends AbstractEnrollmentState
{
    public function name(): string
    {
        return 'Draft';
    }

    public function submit(EnrollmentApplication $application): string
    {
        $application->transitionTo(new SubmittedState());
        return 'Enrollment application submitted.';
    }
}

final class SubmittedState extends AbstractEnrollmentState
{
    public function name(): string
    {
        return 'Submitted';
    }

    public function approve(EnrollmentApplication $application): string
    {
        $application->transitionTo(new ApprovedState());
        return 'Enrollment application approved.';
    }

    public function reject(EnrollmentApplication $application): string
    {
        $application->transitionTo(new RejectedState());
        return 'Enrollment application rejected.';
    }
}

final class ApprovedState extends AbstractEnrollmentState
{
    public function name(): string
    {
        return 'Approved';
    }
}

final class RejectedState extends AbstractEnrollmentState
{
    public function name(): string
    {
        return 'Rejected';
    }
}

final class EnrollmentApplication
{
    private EnrollmentState $state;

    public function __construct()
    {
        $this->state = new DraftState();
    }

    public function transitionTo(EnrollmentState $state): void
    {
        $this->state = $state;
    }

    public function submit(): string
    {
        return $this->state->submit($this);
    }

    public function approve(): string
    {
        return $this->state->approve($this);
    }

    public function reject(): string
    {
        return $this->state->reject($this);
    }

    public function status(): string
    {
        return $this->state->name();
    }
}
