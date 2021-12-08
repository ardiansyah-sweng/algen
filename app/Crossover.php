<?php

class Crossover
{
    public $popSize;
    public $crossoverRate;

    function randomizingParents():array
    {
        $parents = [];
        $counter = 0;
        while ($counter < 1){
            for ($i = 0; $i < $this->popSize; $i++) {
                $randomZeroToOne = (float) rand() / (float) getrandmax();
                if ($randomZeroToOne < $this->crossoverRate) {
                    $parents[$i] = $randomZeroToOne;
                }
            }
            if (count($parents) > 0) {
                return $parents;
            }
            $counter = 0;
            $parents = [];
        }
        return $parents;
    }

    function generateCrossover():array
    {
        $parents = $this->randomizingParents();
        $ret = [];

        foreach (array_keys($parents) as $key){
            foreach (array_keys($parents) as $subKey){
                if ($key !== $subKey){
                    $ret[] = [$key, $subKey];
                }
            }
            array_shift($parents);
        }
        return $ret;
    }

    function runCrossover()
    {
        $chromosome = new Chromosome;
        $chromosomes = $chromosome->createChromosome();
        $cutPointIndex = rand(0, count($chromosomes)-1 );
        return $cutPointIndex;
    }
}