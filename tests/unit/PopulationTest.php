<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class PopulationTest extends TestCase
{
    function testGeneratePopulation()
    {
        $catalogue = new Catalogue;
        $population = new Population(10, $catalogue->getAllProducts());
        $numOfGen = count($catalogue->getAllProducts());
        
        if ($population->generatePopulation()){
            $this->assertNotEmpty($population->generatePopulation());
            $this->assertEquals($numOfGen, count($population->generatePopulation()[0]));
            $this->assertEquals($population->popSize, count($population->generatePopulation()));
        } else {
            $this->assertEmpty($population->generatePopulation());
        }
    }
}