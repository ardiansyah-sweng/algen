<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class PopulationTest extends TestCase
{
    function testGeneratePopulation()
    {
        $population = new Population;
        $catalogue = new Catalogue;
        $numOfGen = count($catalogue->getAllProducts());

        $population->popSize = 10;
        
        if ($population->generatePopulation()){
            $this->assertNotEmpty($population->generatePopulation());
            $this->assertEquals($numOfGen, count($population->generatePopulation()[0]));
            $this->assertEquals($population->popSize, count($population->generatePopulation()));
        } else {
            $this->assertEmpty($population->generatePopulation());
        }
    }
}