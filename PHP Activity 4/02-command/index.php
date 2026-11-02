<?php
declare(strict_types=1);

require __DIR__ . '/Pattern.php';

use BehavioralPatterns\Command\CommandInvoker;
use BehavioralPatterns\Command\DropSubjectCommand;
use BehavioralPatterns\Command\EnrollStudentCommand;
use BehavioralPatterns\Command\LogoutCommand;
use BehavioralPatterns\Command\PrintRegistrationCommand;
use BehavioralPatterns\Command\StudentSystem;

$system = new StudentSystem();
$invoker = new CommandInvoker();
$output = [];

foreach ([
    new EnrollStudentCommand($system),
    new DropSubjectCommand($system, 'IT101'),
] as $command) {
    $output = [...$output, ...$invoker->execute($command)];
}

$output = [...$output, ...$invoker->undoLast()];
$output = [...$output, ...$invoker->execute(new PrintRegistrationCommand($system))];
$output = [...$output, ...$invoker->execute(new LogoutCommand($system))];
$output = [...$output, ...$invoker->undoLast()];
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Command Pattern</title></head>
<body>
    <h1>Command: Student System Actions</h1>
    <p>Commands encapsulate enrollment, dropping a subject, printing registration, and logout. The invoker records commands so reversible actions can be undone.</p>
    <pre><?= htmlspecialchars(implode("\n", $output), ENT_QUOTES, 'UTF-8') ?></pre>
    <p>Subjects after undo: <?= htmlspecialchars(implode(', ', $system->subjects()), ENT_QUOTES, 'UTF-8') ?></p>
    <p><a href="../">Back to all patterns</a></p>
</body>
</html>
