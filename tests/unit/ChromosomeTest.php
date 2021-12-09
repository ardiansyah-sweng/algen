<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class ChromosomeTest extends TestCase
{
    function testCreateChromosome_isReturned()
    {
        $catalogue = new Catalogue;
        $allProduct = $catalogue->getAllProducts();
        $chromosome = new Chromosome($allProduct);
        $chromosomes = $chromosome->createChromosome();

        if ($chromosomes){
            $this->assertNotEmpty($chromosomes);
            $this->assertContainsEquals(0, $chromosomes);
            $this->assertContainsEquals(1, $chromosomes);
        } else {
            $this->assertEmpty($chromosomes);
        }
    }
}
