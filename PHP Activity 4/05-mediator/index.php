<?php
declare(strict_types=1);

require __DIR__ . '/Pattern.php';

use BehavioralPatterns\Mediator\ChatRoom;
use BehavioralPatterns\Mediator\Student;

$chat = new ChatRoom();
$juan = new Student('Juan', $chat);
$maria = new Student('Maria', $chat);
$pedro = new Student('Pedro', $chat);

foreach ([$juan, $maria, $pedro] as $student) {
    $chat->register($student);
}

$messages = $juan->send('Hello everyone!');
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Mediator Pattern</title></head>
<body>
    <h1>Mediator: Student Communication System</h1>
    <p>Students send messages to the chat mediator; they do not address other student objects directly.</p>
    <pre><?= htmlspecialchars(implode("\n\n", $messages), ENT_QUOTES, 'UTF-8') ?></pre>
    <p><a href="../">Back to all patterns</a></p>
</body>
</html>
