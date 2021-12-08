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
        $crossover->popSize = 10;
        $crossover->crossoverRate = 0.8;
        $parents = $crossover->generateCrossover();
        $this->assertNotEmpty($parents);
    }
}