<?php
require 'vendor/autoload.php';

class Main
{
    public $popSize;
    public $maxGen;
    public $maxBudget;
    public $crossoverRate;

    // function __construct(int $popSize, int $maxGen, float $maxBudget, float $crossoverRate)
    // {
    //     $this->popSize = $popSize;
    //     $this->maxGen = $maxGen;
    //     $this->maxBudget = $maxBudget;
    //     $this->crossoverRate = $crossoverRate;
    // }

    function runMain()
    {
        $population = new InitialPopulation;   
        $population->popSize = $this->popSize;
        $populations = $population->generatePopulation(new Chromosome);

        $crossover = new Crossover;
        $crossover->popSize = $this->popSize;
        $crossover->crossoverRate = $this->crossoverRate;
        return $crossover->runCrossover($populations);

        for ($i = 0; $i < $this->maxGen; $i++){
            $crossoverOffsprings = $crossover->runCrossover($populations);
            return $crossoverOffsprings;
        }
    }
}

//$main = new Main(10, 100, 155000, 0.8);
//$main->runMain();