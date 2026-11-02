<?php
declare(strict_types=1);

namespace BehavioralPatterns\TemplateMethod;

abstract class StudentReportGenerator
{
    final public function generate(array $data): string
    {
        return implode("\n", [
            $this->header(),
            $this->renderBody($data),
            $this->footer(),
        ]);
    }

    protected function header(): string
    {
        return 'STUDENT REPORT';
    }

    abstract protected function renderBody(array $data): string;

    protected function footer(): string
    {
        return '--- End of report ---';
    }
}

final class AcademicReportGenerator extends StudentReportGenerator
{
    protected function renderBody(array $data): string
    {
        if (!isset($data['student'], $data['grades']) || !is_array($data['grades'])) {
            throw new \InvalidArgumentException('Academic report requires a student and grades.');
        }

        $gradeLines = [];
        foreach ($data['grades'] as $subject => $grade) {
            $gradeLines[] = "{$subject}: {$grade}";
        }

        return "Student: {$data['student']}\n" . implode("\n", $gradeLines);
    }
}

final class EnrollmentReportGenerator extends StudentReportGenerator
{
    protected function header(): string
    {
        return 'ENROLLMENT REPORT';
    }

    protected function renderBody(array $data): string
    {
        if (!isset($data['student'], $data['program'], $data['subjects']) || !is_array($data['subjects'])) {
            throw new \InvalidArgumentException('Enrollment report requires student, program, and subjects.');
        }

        return "Student: {$data['student']}\nProgram: {$data['program']}\nSubjects: "
            . implode(', ', $data['subjects']);
    }
}
