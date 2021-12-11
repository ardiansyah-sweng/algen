<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class SelectionTest extends TestCase
{
    function test_runSelection_elitism()
    {
        $population = new InitialPopulation;   
        $population->popSize = 30;
        $generatedPopulation = $population->generatePopulation(new Chromosome);

        $crossover = new Crossover;
        $crossover->popSize = $population->popSize;
        $crossover->crossoverRate = 0.8;

        $crossoverOffsprings = $crossover->runCrossover($generatedPopulation);

        $mutation = new Mutation;
        $mutation->popSize = $population->popSize;
        $mutatedChromosomes = $mutation->runMutation(new MutationCalculator, $generatedPopulation);

        if (count($mutatedChromosomes) > 0){
            foreach ($mutatedChromosomes as $mutatedChromosome){
                $crossoverOffsprings[] = $mutatedChromosome;
            }
        }

        $selectionFactory = new SelectionFactory;
        $result = $selectionFactory->initializeSelectionFactory('elitism',$generatedPopulation, $crossoverOffsprings, 500000);

        print_r($result); die;

        $this->assertIsArray($result);
        $this->assertEquals($population->popSize, count($result));
    }
}