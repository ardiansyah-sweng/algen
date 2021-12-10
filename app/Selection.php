<?php

interface Selection
{
    function generateNewPopulation($population, $maxBudget);
}

class Elitism implements Selection
{
    public $crossoverOffsprings;
    public $catalogue;
    public $popSize;

    function createTemporaryPopulation($population)
    {
        foreach ($this->crossoverOffsprings as $offspring) {
            $population[] = $offspring;
        }
        return $population;
    }

    function generateNewPopulation($population, $maxBudget)
    {
        $tempPopulation = $this->createTemporaryPopulation($population);

        $fitness = new Fitness($population, $maxBudget, $this->catalogue);
        $newPopulation = [];

        foreach ($tempPopulation as $chromosomes){
            $newPopulation[] = [
                'amount' => $fitness->getAmount($chromosomes),
                'chromosomes' => $chromosomes
            ];
            
        }
        //urutkan secara desc dulu
        rsort($newPopulation);
        //baca satu per satu
        foreach ($newPopulation as $key => $population){
            // echo $key.' '. $population['amount'];
            // echo "\n";
        }

        return $newPopulation;
        return array_slice($newPopulation, 0, $this->popSize);
    }
}

class SelectionFactory
{
    function initializeSelectionFactory($selectionType, $population, $crossoverOffsprings, $maxBudget, $catalogue, $popSize)
    {
        if ($selectionType === 'elitism'){
            $elitism = new Elitism;
            $elitism->crossoverOffsprings = $crossoverOffsprings;
            $elitism->catalogue = $catalogue;
            $elitism->popSize = $popSize;
            return $elitism->generateNewPopulation($population, $maxBudget);
        }
    }
}