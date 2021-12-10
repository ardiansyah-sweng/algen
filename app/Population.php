<?php

class InitialPopulation
{
    function generatePopulation($popSize, $chromosomes): array
    {
        $population = [];
        if ($popSize > 0) {
            for ($i = 0; $i < $popSize; $i++) {
                $population[] = $chromosomes;
            }
        }
        return $population;
    }
}
