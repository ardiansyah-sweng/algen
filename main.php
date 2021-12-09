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

        for ($i = 0; $i < $this->maxGen; $i++){
            $crossoverOffsprings = $crossover->runCrossover($populations);
            $mutation = new Mutation;
            $mutation->popSize = $this->popSize;
            $mutatedChromosomes = $mutation->runMutation(new MutationCalculator, $populations);
            
            // Jika ada hasil mutasi, maka gabungkan chromosomes offspring dengan hasil chromosome mutasi
            if (count($mutatedChromosomes) > 0){
                foreach ($mutatedChromosomes as $mutatedChromosome){
                    $crossoverOffsprings[] = $mutatedChromosome;
                }
            }

        }
    }
}

//$main = new Main(10, 100, 155000, 0.8);
//$main->runMain();