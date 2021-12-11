<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class FitnessTest extends TestCase
{
    var float $maxBudget = 50000;

    function test_assigningGenWithPrice()
    {
        $population = new Population;
        $population->popSize = 10;
        $populations = $population->generatePopulation();
        $fitness = new Fitness($populations, $this->maxBudget);
        $chromosomes = [1, 0, 1, 1, 0, 1, 0, 0, 1, 1];
        $this->assertNotNull($fitness->assigningGenWithPrice($chromosomes));
    }

    function test_assigningGenWithPrice_allGenesIsZero()
    {
        $population = new Population;
        $population->popSize = 10;
        $populations = $population->generatePopulation();
        $fitness = new Fitness($populations, $this->maxBudget);
        $chromosomes = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $this->assertEquals(0, $fitness->assigningGenWithPrice($chromosomes)[0]['price']);
    }

    function test_calculateFitnessValue()
    {
        $population = new InitialPopulation;
        $population->popSize = 10;
        $populations = $population->generatePopulation(new Chromosome);
        $fitness = new Fitness($populations, $this->maxBudget);

        $fitnessValues = $fitness->calculateFitnessValue();
        if (empty($fitnessValues)){
            $this->assertEmpty($fitnessValues);
        } else {
            $this->assertNotEmpty($fitnessValues);
            $this->assertNotNull($fitnessValues[rand(0,count($fitnessValues)-1)]['numOfSelectedGen']);
            $this->assertNotNull($fitnessValues[rand(0, count($fitnessValues))]['fitnessValue']);
            $this->assertGreaterThan(10000, $fitnessValues[rand(0, count($fitnessValues)-1)]['fitnessValue']);
        }
    }

    function test_fitnessEvaluation()
    {
        $population = new Population;
        $population->popSize = 10;
        $populations = $population->generatePopulation();
        $fitness = new Fitness($populations, $this->maxBudget);
        $fitnessValues = $fitness->fitnessEvaluation();
        
        if (empty($fitnessValues)) {
            $this->assertEmpty($fitnessValues);
        } else {
            $this->assertNotEmpty($fitnessValues);
            $this->assertContainsEquals(0,$fitnessValues[0]['chromosome']);
        }
    }
}
