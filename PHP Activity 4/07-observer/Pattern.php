<?php
declare(strict_types=1);

namespace BehavioralPatterns\Observer;

interface GradeObserver
{
    public function update(string $student, string $subject, float $grade): string;
}

final class GradeNotificationSubscriber implements GradeObserver
{
    public function __construct(private string $subscriberName)
    {
    }

    public function update(string $student, string $subject, float $grade): string
    {
        return sprintf(
            '%s notified: %s received %.1f in %s.',
            $this->subscriberName,
            $student,
            $grade,
            $subject
        );
    }
}

final class GradePublisher
{
    private array $observers = [];

    public function attach(GradeObserver $observer): void
    {
        $this->observers[spl_object_id($observer)] = $observer;
    }

    public function detach(GradeObserver $observer): void
    {
        unset($this->observers[spl_object_id($observer)]);
    }

    public function publish(string $student, string $subject, float $grade): array
    {
        $messages = [];
        foreach ($this->observers as $observer) {
            $messages[] = $observer->update($student, $subject, $grade);
        }

        return $messages;
    }
}
