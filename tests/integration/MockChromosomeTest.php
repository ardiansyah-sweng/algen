<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class MockChromosomeTest extends TestCase
{
    function testCreateChromosome_isReturned()
    {
        $chromosomes = [];
        $catalogue = new Catalogue;
        $numOfProducts = count($catalogue->getAllProducts());

        for ($i = 0; $i < $numOfProducts; $i++){
            $chromosomes[] = rand(0,1);
        }

        $mockChromosome = $this->createMock(Chromosome::class);
        $mockChromosome->method('createChromosome')
                        ->willReturn($chromosomes);
        $chromosome = $mockChromosome->createChromosome();
        $this->assertNotEmpty($chromosome);
    }
}