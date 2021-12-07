<?php

require 'vendor/autoload.php';

class Fitness
{

    public $populations;
    public $maxBudget;

    function __construct(array $populations, float $maxBudget)
    {
        $this->populations = $populations;
        $this->maxBudget = $maxBudget;
    }

    function assigningGenWithPrice(array $chromosomes): array
    {
        $binary1Genes = [];
        $catalogue = new Catalogue;
        $products = $catalogue->getAllProducts();

        if (count(array_unique($chromosomes)) > 1) {
            foreach ($chromosomes as $key => $gen) {
                if ($gen === 1) {
                    $binary1Genes[] = [
                        'selectedGen' => $key,
                        'price' => $products[$key]['item_price']
                    ];
                }
            }
        }

        if (count(array_unique($chromosomes)) === 1) {
            foreach ($chromosomes as $key => $gen) {
                $binary1Genes[] = [
                    'selectedGen' => 0,
                    'price' => 0
                ];
            }
        }

        return $binary1Genes;
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
