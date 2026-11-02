<?php
declare(strict_types=1);

require __DIR__ . '/Pattern.php';

use BehavioralPatterns\Memento\ProfileHistory;
use BehavioralPatterns\Memento\StudentProfile;

$profile = new StudentProfile('Juan Dela Cruz', 'juan@example.test', 'BSIT');
$history = new ProfileHistory();
$history->save($profile);
$original = $profile->details();
$profile->update('Juan D. Cruz', 'new-address@example.test', 'BSCS');
$updated = $profile->details();
$history->undo($profile);
$restored = $profile->details();
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Memento Pattern</title></head>
<body>
    <h1>Memento: Student Profile Undo System</h1>
    <p>Original: <?= htmlspecialchars($original, ENT_QUOTES, 'UTF-8') ?></p>
    <p>After edit: <?= htmlspecialchars($updated, ENT_QUOTES, 'UTF-8') ?></p>
    <p>After undo: <?= htmlspecialchars($restored, ENT_QUOTES, 'UTF-8') ?></p>
    <p><a href="../">Back to all patterns</a></p>
</body>
</html>
