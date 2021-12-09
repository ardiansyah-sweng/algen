<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class PopulationTest extends TestCase
{
    function test_GenerateInitialPopulation_notEmpty()
    {
        $population = new InitialPopulation;   
        $population->popSize = 10;
        $generatedPopulation = $population->generatePopulation(new Chromosome);

        //echo $numOfGen;die;
                
        $this->assertGreaterThan(5, count($generatedPopulation));
        $this->assertNotEmpty($generatedPopulation);
        $this->assertEquals(10, count($generatedPopulation));
        $this->assertEquals(50, count($generatedPopulation[0]));
        $this->assertEquals($population->popSize, count($generatedPopulation));
    }

    function test_generatePopulation_isEmpty()
    {
        $population = new InitialPopulation;   
        $population->popSize = 0;
        $generatedPopulation = $population->generatePopulation(new Chromosome);

        $this->assertEmpty($generatedPopulation);
    }
}