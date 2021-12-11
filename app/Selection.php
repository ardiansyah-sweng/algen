<?php

interface Selection
{
    function generateNewPopulation($population, $maxBudget);
}

class RouletteWheel implements Selection
{
    function generateNewPopulation($population, $maxBudget)
    {
        //
    }
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

    function check(array $checkPopulations, int $popSize, array $newPopulation, float $maxBudget)
    {
        if (count($checkPopulations) === $popSize){
            if ($checkPopulations[0]['amount'] <= $maxBudget){
                return $checkPopulations;
            }
            for ($i = $popSize; $i < count($newPopulation); $i++) {
                array_shift($checkPopulations);
                $checkPopulations[] = $newPopulation[$i];
                if ($checkPopulations[0]['amount'] <= $maxBudget){
                    return $checkPopulations;
                }
            }
            return $checkPopulations;
        }
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
        foreach ($newPopulation as $chromosomes) {
            $checkPopulations[] = $chromosomes;
            $result = $this->check($checkPopulations, $this->popSize, $newPopulation, $maxBudget);
            if ($result){
                return $result;
            }
        }
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

        if ($selectionType === 'roulettee'){
            //
        }
    }
}