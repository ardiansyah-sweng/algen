<?php

interface Selection
{
    function selectingSelection($population, $maxBudget);
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

    function selectingSelection($population, $maxBudget)
    {
        $tempPopulation = $this->createTemporaryPopulation($population);
        $fitness = new Fitness($population, $maxBudget);
        $fitChromosomes = [];

        foreach ($tempPopulation as $chromosomes){
            $amount = $fitness->getAmount($chromosomes);
            if ($amount <= $maxBudget){
                $fitChromosomes[] = [
                    'amount' => $amount,
                    'chromosomes' => $chromosomes
                ];
            }
        }
        rsort($fitChromosomes);
        $fitChromosomes = array_slice($fitChromosomes, 0, count($population));

        return $fitChromosomes;
    }
}

class SelectionFactory
{
    function initializeSelectionFactory($selectionType, $population, $crossoverOffsprings, $maxBudget)
    {
        if ($selectionType === 'elitism'){
            $elitism = new Elitism;
            $elitism->crossoverOffsprings = $crossoverOffsprings;
            return $elitism->selectingSelection($population, $maxBudget);
        }
    }
}