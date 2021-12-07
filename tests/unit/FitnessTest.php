<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class FitnessTest extends TestCase
{
    function test_assigningGenWithPrice()
    {
        $fitness = new Fitness;
        $chromosomes = [1, 0, 1, 1, 0, 1, 0, 0, 1, 1];
        $this->assertNotNull($fitness->assigningGenWithPrice($chromosomes));
    }

    function test_assigningGenWithPrice_allGenesIsZero()
    {
        $fitness = new Fitness;
        $chromosomes = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $this->assertEquals(0, $fitness->assigningGenWithPrice($chromosomes)[0]['price']);
    }

    function test_calculateFitnessValue()
    {
        $fitness = new Fitness;
        $fitnessValues = $fitness->calculateFitnessValue();
        if (empty($fitnessValues)){
            $this->assertEmpty($fitnessValues);
        } else {
            $this->assertNotEmpty($fitnessValues);
            $this->assertNotNull($fitnessValues[rand(0,count($fitnessValues)-1)]['numOfSelectedGen']);
            $this->assertNotNull($fitnessValues[rand(0, count($fitnessValues))]['amount']);
            $this->assertGreaterThan(10000, $fitnessValues[rand(0, count($fitnessValues)-1)]['amount']);
        }
    }
}
