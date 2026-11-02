<?php
declare(strict_types=1);

require __DIR__ . '/Pattern.php';

use BehavioralPatterns\Iterator\StudentCollection;

$students = new StudentCollection([
    ['id' => 'S001', 'name' => 'Ana Santos', 'program' => 'BSIT'],
    ['id' => 'S002', 'name' => 'Ben Cruz', 'program' => 'BSCS'],
    ['id' => 'S003', 'name' => 'Cara Reyes', 'program' => 'BSIT'],
]);
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Iterator Pattern</title></head>
<body>
    <h1>Iterator: Student Record Collection</h1>
    <p>Client code traverses student records without depending on the collection's internal storage.</p>
    <ul>
        <?php foreach ($students as $student): ?>
            <li><?= htmlspecialchars($student['id'] . ' — ' . $student['name'] . ' (' . $student['program'] . ')', ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
    <p><a href="../">Back to all patterns</a></p>
</body>
</html>
