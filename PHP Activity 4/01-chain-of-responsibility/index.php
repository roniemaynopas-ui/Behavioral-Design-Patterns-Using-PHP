<?php
declare(strict_types=1);

require __DIR__ . '/Pattern.php';

use BehavioralPatterns\ChainOfResponsibility\FinanceHandler;
use BehavioralPatterns\ChainOfResponsibility\IctHandler;
use BehavioralPatterns\ChainOfResponsibility\RegistrarHandler;
use BehavioralPatterns\ChainOfResponsibility\StudentAffairsHandler;
use BehavioralPatterns\ChainOfResponsibility\StudentRequest;

$studentAffairs = new StudentAffairsHandler();
$registrar = new RegistrarHandler();
$finance = new FinanceHandler();
$ict = new IctHandler();
$studentAffairs->setNext($registrar);
$registrar->setNext($finance);
$finance->setNext($ict);

$request = new StudentRequest('Transcript of Records');
$messages = ["Request: {$request->type}", ...$studentAffairs->handle($request)];
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Chain of Responsibility Pattern</title></head>
<body>
    <h1>Chain of Responsibility: Student Request Processing</h1>
    <p>Each office either handles the request or forwards it to the next office.</p>
    <pre><?= htmlspecialchars(implode("\n", $messages), ENT_QUOTES, 'UTF-8') ?></pre>
    <p><a href="../">Back to all patterns</a></p>
</body>
</html>
