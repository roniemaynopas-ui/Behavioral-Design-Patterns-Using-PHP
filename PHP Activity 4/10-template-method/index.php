<?php
declare(strict_types=1);

require __DIR__ . '/Pattern.php';

use BehavioralPatterns\TemplateMethod\AcademicReportGenerator;
use BehavioralPatterns\TemplateMethod\EnrollmentReportGenerator;

$academicReport = (new AcademicReportGenerator())->generate([
    'student' => 'Juan Dela Cruz',
    'grades' => ['Programming' => 92, 'Databases' => 88],
]);
$enrollmentReport = (new EnrollmentReportGenerator())->generate([
    'student' => 'Juan Dela Cruz',
    'program' => 'BSIT',
    'subjects' => ['IT101', 'IT102', 'IT103'],
]);
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Template Method Pattern</title></head>
<body>
    <h1>Template Method: Student Report Generation</h1>
    <p>The base class fixes the report-generation sequence; subclasses customize report content.</p>
    <h2>Academic report</h2>
    <pre><?= htmlspecialchars($academicReport, ENT_QUOTES, 'UTF-8') ?></pre>
    <h2>Enrollment report</h2>
    <pre><?= htmlspecialchars($enrollmentReport, ENT_QUOTES, 'UTF-8') ?></pre>
    <p><a href="../">Back to all patterns</a></p>
</body>
</html>
