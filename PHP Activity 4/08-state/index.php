<?php
declare(strict_types=1);

require __DIR__ . '/Pattern.php';

use BehavioralPatterns\State\EnrollmentApplication;

$application = new EnrollmentApplication();
$messages = [$application->status()];
$messages[] = $application->submit();
$messages[] = $application->approve();
$messages[] = 'Current status: ' . $application->status();
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>State Pattern</title></head>
<body>
    <h1>State: Student Enrollment Status</h1>
    <p>Allowed enrollment actions are determined by the application's current state.</p>
    <pre><?= htmlspecialchars(implode("\n", $messages), ENT_QUOTES, 'UTF-8') ?></pre>
    <p><a href="../">Back to all patterns</a></p>
</body>
</html>
