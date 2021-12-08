<?php

class Population
{
    public $popSize;

    function generatePopulation(): array
    {
        $population = [];
        if ($this->popSize > 0) {
            for ($i = 0; $i < $this->popSize; $i++) {
                $population[] = (new Chromosome())->createChromosome();
            }
        }
        return $population;
    }
}
