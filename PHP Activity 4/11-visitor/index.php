<?php
declare(strict_types=1);

require __DIR__ . '/Pattern.php';

use BehavioralPatterns\Visitor\AcademicStandingVisitor;
use BehavioralPatterns\Visitor\GraduateRecord;
use BehavioralPatterns\Visitor\TranscriptVisitor;
use BehavioralPatterns\Visitor\UndergraduateRecord;

$records = [
    new UndergraduateRecord('Ana Santos', 'BSIT', 4, 3.7),
    new GraduateRecord('Ben Cruz', 'MSCS', 'Accessible learning systems', 3.8),
];
$visitors = [new TranscriptVisitor(), new AcademicStandingVisitor()];
$results = [];
foreach ($visitors as $visitor) {
    foreach ($records as $record) {
        $results[] = $record->accept($visitor);
    }
}
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Visitor Pattern</title></head>
<body>
    <h1>Visitor: Student Record Operations</h1>
    <p>Different operations can be applied to undergraduate and graduate records without changing the record classes.</p>
    <ul>
        <?php foreach ($results as $result): ?>
            <li><?= htmlspecialchars($result, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
    <p><a href="../">Back to all patterns</a></p>
</body>
</html>
