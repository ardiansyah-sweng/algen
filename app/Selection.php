<?php

interface Selection
{
    function generateNewPopulation($population, $maxBudget);
}

class Elitism implements Selection
{
    public $crossoverOffsprings;

    function createTemporaryPopulation($population)
    {
        foreach ($this->crossoverOffsprings as $offspring) {
            $population[] = $offspring;
        }
        return $population;
    }

    function generateNewPopulation($population, $maxBudget):array
    {
        $tempPopulation = $this->createTemporaryPopulation($population);
        $fitness = new Fitness($population, $maxBudget);
        $newPopulation = [];

        foreach ($tempPopulation as $chromosomes){
            $amount = $fitness->getAmount($chromosomes);
            if ($amount <= $maxBudget){
                $newPopulation[] = [
                    'amount' => $amount,
                    'chromosomes' => $chromosomes
                ];
            }
        }
        rsort($newPopulation);
        $newPopulation = array_slice($newPopulation, 0, count($population));

        return $newPopulation;
    }
}

class SelectionFactory
{
    function initializeSelectionFactory($selectionType, $population, $crossoverOffsprings, $maxBudget)
    {
        if ($selectionType === 'elitism'){
            $elitism = new Elitism;
            $elitism->crossoverOffsprings = $crossoverOffsprings;
            return $elitism->generateNewPopulation($population, $maxBudget);
        }
    }
}