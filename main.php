<?php
require 'vendor/autoload.php';

class Main
{
    public $popSize;
    public $maxGen;
    public $maxBudget;
    public $crossoverRate;

    function __construct(int $popSize, int $maxGen, float $maxBudget, float $crossoverRate)
    {
        $this->popSize = $popSize;
        $this->maxGen = $maxGen;
        $this->maxBudget = $maxBudget;
        $this->crossoverRate = $crossoverRate;
    }

    function runMain()
    {
        $catalogue = new Catalogue;
        $catalogues = $catalogue->getAllProducts();
        $population = new Population($this->popSize, $catalogues);

        $crossover = new Crossover;
        $crossover->popSize = $this->popSize;
        $crossover->crossoverRate = $this->crossoverRate;
        $crossover->runCrossover(new Chromosome($catalogues));
        

        $population->popSize = $this->popSize;
        $populations = $population->generatePopulation();

        for ($generation = 0; $generation < $this->maxGen; $generation++){
            
        }


        // $fitness = new Fitness($populations, $this->maxBudget);
        // return $fitness->fitnessEvaluation();
    }
}

$main = new Main(10, 100, 155000, 0.8);
$main->runMain();