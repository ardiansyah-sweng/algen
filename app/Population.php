<?php

class InitialPopulation
{
    public $popSize;

    function generatePopulation(Chromosome $chromosome): array
    {
        $population = [];
        if ($this->popSize > 0) {
            for ($i = 0; $i < $this->popSize; $i++) {
                $population[] = $chromosome->createChromosome(new Catalogue);;
            }
        }
        return $population;
    }
}
