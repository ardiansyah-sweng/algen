<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class ChromosomeTest extends TestCase
{
    function testCreateChromosome_isReturned()
    {
        $chromosome = new Chromosome;
        if ($chromosome->createChromosome()){
            $this->assertNotEmpty($chromosome->createChromosome());
            $this->assertContainsEquals(0, $chromosome->createChromosome());
            $this->assertContainsEquals(1, $chromosome->createChromosome());
        } else {
            $this->assertEmpty($chromosome->createChromosome());
        }
    }
}
