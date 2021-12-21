<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class ChromosomeTest extends TestCase
{
    /**
     * @covers
     */
    function testCreateChromosome_isReturned()
    {
        $catalogue = new Catalogue;
        $chromosome = new Chromosome($catalogue->getAllProducts());
        $chromosomes = $chromosome->createChromosome(count($catalogue->getAllProducts()));
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
