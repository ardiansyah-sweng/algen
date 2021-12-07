<?php

use phpDocumentor\Reflection\Types\Integer;

require 'vendor/autoload.php';

class Fitness
{
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
        $population = new Population;
        $population->popSize = 10; //move to main

        $chromosomeWithFitnessValues = [];
        if (empty($population->generatePopulation()[0])) {
            return $chromosomeWithFitnessValues;
        }
        foreach ($population->generatePopulation() as $chromosomes) {
            $assignedGenes = $this->assigningGenWithPrice($chromosomes);
            $chromosomeWithFitnessValues[] =
                [
                    'numOfSelectedGen' => count($assignedGenes),
                    'amount' => array_sum(array_column($assignedGenes, 'price')),
                    'chromosome' => $chromosomes
                ];
        }
        return $chromosomeWithFitnessValues;
    }
}
