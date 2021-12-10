<?php

require 'vendor/autoload.php';

class Fitness
{

    public $populations;
    public $maxBudget;
    public $catalogue;

    function __construct(array $populations, float $maxBudget, array $catalogue)
    {
        $this->populations = $populations;
        $this->maxBudget = $maxBudget;
        $this->catalogue = $catalogue;
    }

    function getAmount(array $chromosomes): float
    {
        $amount = 0;
        if (count(array_unique($chromosomes)) > 1) {
            foreach ($chromosomes as $key => $gen) {
                if ($gen === 1) {
                    $amount += $this->catalogue[$key]['item_price'];
                }
            }
        }
        return $amount;
    }

    function calculateFitnessValue(): array
    {
        $chromosomeWithFitnessValues = [];
        if (empty($this->populations[0])) {
            return $chromosomeWithFitnessValues;
        }
        foreach ($this->populations as $chromosomes) {
            $assignedGenes = $this->assigningGenWithPrice($chromosomes);
            $chromosomeWithFitnessValues[] =
                [
                    'numOfSelectedGen' => count($assignedGenes),
                    'fitnessValue' => array_sum(array_column($assignedGenes, 'price')),
                    'chromosome' => $chromosomes
                ];
        }
        return $chromosomeWithFitnessValues;
    }

    function fitnessEvaluation(): array
    {
        $fitChromosomes = [];

        $fitnessValues = $this->calculateFitnessValue();
        if (empty($fitnessValues)) {
            return $fitChromosomes;
        }

        foreach ($fitnessValues as $chromosomes) {
            if ($chromosomes['fitnessValue'] <= $this->maxBudget) {
                $fitChromosomes[] = $chromosomes;
            }
        }
        return $fitChromosomes;
    }
}
