<?php
declare(strict_types=1);

namespace BehavioralPatterns\Strategy;

interface GradeCalculationStrategy
{
    public function calculate(array $scores): float;

    public function name(): string;
}

final class SimpleAverageStrategy implements GradeCalculationStrategy
{
    public function calculate(array $scores): float
    {
        if ($scores === []) {
            throw new \InvalidArgumentException('At least one score is required.');
        }

        $values = array_column($scores, 'score');
        return array_sum($values) / count($values);
    }

    public function name(): string
    {
        return 'Simple average';
    }
}

final class WeightedAverageStrategy implements GradeCalculationStrategy
{
    public function calculate(array $scores): float
    {
        if ($scores === []) {
            throw new \InvalidArgumentException('At least one score is required.');
        }

        $weightedTotal = 0.0;
        $totalWeight = 0.0;
        foreach ($scores as $item) {
            if (!isset($item['score'], $item['weight']) || $item['weight'] < 0) {
                throw new \InvalidArgumentException('Each score needs a non-negative weight.');
            }

            $weightedTotal += $item['score'] * $item['weight'];
            $totalWeight += $item['weight'];
        }

        if ($totalWeight <= 0.0) {
            throw new \InvalidArgumentException('The total weight must be greater than zero.');
        }

        return $weightedTotal / $totalWeight;
    }

    public function name(): string
    {
        return 'Weighted average';
    }
}

final class GradeCalculator
{
    public function __construct(private GradeCalculationStrategy $strategy)
    {
    }

    public function setStrategy(GradeCalculationStrategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function calculate(array $scores): float
    {
        return $this->strategy->calculate($scores);
    }

    public function strategyName(): string
    {
        return $this->strategy->name();
    }
}
