<?php

class Chromosome
{
    public $catalogue;

    function __construct(array $catalogue)
    {
        $this->catalogue = $catalogue;
    }

    function createChromosome():array
    {
        $chromosomes = [];  
        $numOfGen = count($this->catalogue);

        if ($numOfGen > 0) {
            $counter = 0;
            while ($counter < 1) {
                for ($i = 0; $i < $numOfGen; $i++) {
                    $chromosomes[] = rand(0, 1);
                }
                if (count(array_unique($chromosomes)) > 1) {
                    return $chromosomes;
                }
                $counter = 0;
                $chromosomes = [];
            }
        }
        return $chromosomes;
    }
}