<?php
declare(strict_types=1);

namespace BehavioralPatterns\Visitor;

interface StudentRecordVisitor
{
    public function visitUndergraduate(UndergraduateRecord $record): string;

    public function visitGraduate(GraduateRecord $record): string;
}

interface StudentRecord
{
    public function accept(StudentRecordVisitor $visitor): string;
}

final class UndergraduateRecord implements StudentRecord
{
    public function __construct(
        public readonly string $name,
        public readonly string $program,
        public readonly int $year,
        public readonly float $gpa
    ) {
    }

    public function accept(StudentRecordVisitor $visitor): string
    {
        return $visitor->visitUndergraduate($this);
    }
}

final class GraduateRecord implements StudentRecord
{
    public function __construct(
        public readonly string $name,
        public readonly string $program,
        public readonly string $researchTopic,
        public readonly float $gpa
    ) {
    }

    public function accept(StudentRecordVisitor $visitor): string
    {
        return $visitor->visitGraduate($this);
    }
}

final class TranscriptVisitor implements StudentRecordVisitor
{
    public function visitUndergraduate(UndergraduateRecord $record): string
    {
        return sprintf(
            'Undergraduate transcript: %s, %s year %d, GPA %.2f.',
            $record->name,
            $record->program,
            $record->year,
            $record->gpa
        );
    }

    public function visitGraduate(GraduateRecord $record): string
    {
        return sprintf(
            'Graduate transcript: %s, %s, research "%s", GPA %.2f.',
            $record->name,
            $record->program,
            $record->researchTopic,
            $record->gpa
        );
    }
}

final class AcademicStandingVisitor implements StudentRecordVisitor
{
    public function visitUndergraduate(UndergraduateRecord $record): string
    {
        return $this->standing($record->name, $record->gpa);
    }

    public function visitGraduate(GraduateRecord $record): string
    {
        return $this->standing($record->name, $record->gpa);
    }

    private function standing(string $name, float $gpa): string
    {
        $standing = $gpa >= 3.5 ? 'Honors eligible' : 'Regular standing';
        return "{$name}: {$standing}.";
    }
}
