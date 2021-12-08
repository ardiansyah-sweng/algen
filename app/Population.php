<?php

class Population
{
    public $popSize;
    public $catalogue;

    function __construct(int $popSize, array $catalogue)
    {
        $this->popSize = $popSize;
        $this->catalogue = $catalogue;
    }

    function generatePopulation(): array
    {
        $population = [];
        if ($this->popSize > 0) {
            for ($i = 0; $i < $this->popSize; $i++) {
                $population[] = (new Chromosome($this->catalogue))->createChromosome();
            }
        }
        return $population;
    }
}
