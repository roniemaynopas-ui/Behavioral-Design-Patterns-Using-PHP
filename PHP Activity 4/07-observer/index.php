<?php
declare(strict_types=1);

require __DIR__ . '/Pattern.php';

use BehavioralPatterns\Observer\GradeNotificationSubscriber;
use BehavioralPatterns\Observer\GradePublisher;

$gradebook = new GradePublisher();
$gradebook->attach(new GradeNotificationSubscriber('Maria'));
$gradebook->attach(new GradeNotificationSubscriber('Pedro'));
$notifications = $gradebook->publish('Juan', 'Object-Oriented Programming', 92.0);
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Observer Pattern</title></head>
<body>
    <h1>Observer: Grade Notification System</h1>
    <p>Subscribed observers are notified when a grade is published.</p>
    <pre><?= htmlspecialchars(implode("\n", $notifications), ENT_QUOTES, 'UTF-8') ?></pre>
    <p><a href="../">Back to all patterns</a></p>
</body>
</html>
