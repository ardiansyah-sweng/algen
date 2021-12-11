<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class ChromosomeTest extends TestCase
{
    function testCreateChromosome_isReturned()
    {
        $chromosome = new Chromosome;
        $chromosomes = $chromosome->createChromosome(new Catalogue);
        //print_r($chromosomes);die;
        if ($chromosomes){
            $this->assertNotEmpty($chromosomes);
            $this->assertContainsEquals(0, $chromosomes);
            $this->assertContainsEquals(1, $chromosomes);
        } else {
            $this->assertEmpty($chromosomes);
        }
    }
}
