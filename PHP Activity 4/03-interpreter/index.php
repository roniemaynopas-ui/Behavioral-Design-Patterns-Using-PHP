<?php
declare(strict_types=1);

require __DIR__ . '/Pattern.php';

use BehavioralPatterns\Interpreter\StudentContext;

$context = new StudentContext([
    ['name' => 'Ana', 'program' => 'BSIT', 'year' => 4],
    ['name' => 'Ben', 'program' => 'BSCS', 'year' => 4],
    ['name' => 'Cara', 'program' => 'BSIT', 'year' => 2],
]);
$query = 'PROGRAM = "BSIT" AND YEAR = 4';
$andResults = $context->search($query);
$orQuery = 'PROGRAM = "BSIT" OR PROGRAM = "BSCS"';
$orResults = $context->search($orQuery);
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Interpreter Pattern</title></head>
<body>
    <h1>Interpreter: Student Search/Query System</h1>
    <p>Query: <code><?= htmlspecialchars($query, ENT_QUOTES, 'UTF-8') ?></code></p>
    <p>Matching students: <?= htmlspecialchars(implode(', ', array_column($andResults, 'name')), ENT_QUOTES, 'UTF-8') ?></p>
    <p><code><?= htmlspecialchars($orQuery, ENT_QUOTES, 'UTF-8') ?></code> matches <?= count($orResults) ?> students.</p>
    <p><a href="../">Back to all patterns</a></p>
</body>
</html>
