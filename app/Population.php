<?php

class InitialPopulation
{
    function generatePopulation(int $popSize, array $catalogue, int $numOfGen): array
    {
        $population = [];
        $chromosome = new Chromosome($catalogue);
        if ($popSize > 0) {
            for ($i = 0; $i < $popSize; $i++) {
                $population[] = $chromosome->createChromosome($numOfGen);
            }
        }
        return $population;
    }
}
