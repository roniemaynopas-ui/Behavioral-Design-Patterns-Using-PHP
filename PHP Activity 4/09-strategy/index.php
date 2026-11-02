<?php
declare(strict_types=1);

require __DIR__ . '/Pattern.php';

use BehavioralPatterns\Strategy\GradeCalculator;
use BehavioralPatterns\Strategy\SimpleAverageStrategy;
use BehavioralPatterns\Strategy\WeightedAverageStrategy;

$scores = [
    ['score' => 80.0, 'weight' => 20.0],
    ['score' => 90.0, 'weight' => 30.0],
    ['score' => 85.0, 'weight' => 50.0],
];

$calculator = new GradeCalculator(new SimpleAverageStrategy());
$simpleAverage = $calculator->calculate($scores);
$calculator->setStrategy(new WeightedAverageStrategy());
$weightedAverage = $calculator->calculate($scores);
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Strategy Pattern</title></head>
<body>
    <h1>Strategy: Grade Calculation System</h1>
    <p>The calculator changes its grade policy at runtime without changing the calculator itself.</p>
    <ul>
        <li><?= htmlspecialchars((new SimpleAverageStrategy())->name(), ENT_QUOTES, 'UTF-8') ?>: <?= number_format($simpleAverage, 2) ?></li>
        <li><?= htmlspecialchars($calculator->strategyName(), ENT_QUOTES, 'UTF-8') ?>: <?= number_format($weightedAverage, 2) ?></li>
    </ul>
    <p><a href="../">Back to all patterns</a></p>
</body>
</html>
