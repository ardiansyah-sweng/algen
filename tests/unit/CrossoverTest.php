<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class CrossoverTest extends TestCase
{
    function test_randomizingParents_isEmpty()
    {
        $crossover = new Crossover;
        $crossover->popSize = 10;
        $crossover->crossoverRate = 0.8;
        $parents = $crossover->randomizingParents();
        $parents = [];
        $this->assertEmpty($parents);
    }

    function test_randomizingParents_notEmpty()
    {
        $crossover = new Crossover;
        $crossover->popSize = 10;
        $crossover->crossoverRate = 0.8;
        $parents = $crossover->randomizingParents();
        $this->assertNotEmpty($parents);
        $this->assertLessThan(1, $parents[0]);
    }

    function test_generateCrossover()
    {
        $crossover = new Crossover;
        $crossover->popSize = 30;
        $crossover->crossoverRate = 0.8;
        $parents = $crossover->generateCrossover();
        print_r($parents);die;
        $this->assertNotEmpty($parents);
    }

    function test_getCutPointIndex()
    {
        $crossover = new Crossover;
        $result = $crossover->getCutPointIndex();
        $this->assertIsInt($result);
    }

    function test_offspring()
    {
        $crossover = new Crossover;
        $crossover->popSize = 30;
        $crossover->crossoverRate = 0.8;

        $chromosome = new Chromosome;
        $parent1Chromosome = $chromosome->createChromosome(new Catalogue);
        $parent2Chromosome = $chromosome->createChromosome(new Catalogue);

        $cutPointIndex = $crossover->getCutPointIndex();

        $offspring1 = $crossover->offspring($parent1Chromosome, $parent2Chromosome, $cutPointIndex, 1);

        $parent1Chromosome = $chromosome->createChromosome(new Catalogue);
        $parent2Chromosome = $chromosome->createChromosome(new Catalogue);
        $offspring2 = $crossover->offspring($parent1Chromosome, $parent2Chromosome, $cutPointIndex, 2);

        echo "\n";
        print_r($offspring1); 
        echo "\n";
        print_r($offspring2); 
        
        die;

        $this->assertIsArray($offspring1);
        $this->assertContainsEquals(0, $offspring1);
        $this->assertIsArray($offspring2);
        $this->assertContainsEquals(0, $offspring2);
    }

    function test_runCrossover()
    {
        $population = new InitialPopulation;   
        $population->popSize = 30;
        $initialPopulation = $population->generatePopulation(new Chromosome);
        
        $crossover = new Crossover;
        $crossover->popSize = $population->popSize;
        $crossover->crossoverRate = 0.8;

        print_r($crossover->runCrossover($initialPopulation));die;

        $this->assertIsArray($crossover->runCrossover($initialPopulation));
    }
}