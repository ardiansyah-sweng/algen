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

    function offspring(array $parent1Chromosome, array $parent2Chromosome, int $cutPointIndex, int $offSpringCode):array
    {
        $chromosome = new Chromosome;
        $chromosomes = $chromosome->createChromosome(new Catalogue);

        if ($offSpringCode === 1){
            for ($i = 0; $i < count($chromosomes); $i++){
                if ($i <= $cutPointIndex){
                    $ret[] = $parent1Chromosome[$i];
                }
                if ($i > $cutPointIndex){
                    $ret[] = $parent2Chromosome[$i];
                }
            }
        }

        if ($offSpringCode === 2){
            for ($i = 0; $i < count($chromosomes); $i++){
                if ($i <= $cutPointIndex){
                    $ret[] = $parent2Chromosome[$i];
                }
                if ($i > $cutPointIndex){
                    $ret[] = $parent1Chromosome[$i];
                }
            }
        }

        return $ret;
    }

    function getCutPointIndex():int
    {
        $chromosome = new Chromosome;
        $chromosomes = $chromosome->createChromosome(new Catalogue);
        return rand(0, count($chromosomes)-1 );
    }
    
    function runCrossover($population):array
    {
        $offsprings = [];
        foreach ($this->generateCrossover() as $listOfCrossover){
            $parent1Chromosome = $population[$listOfCrossover[0]];
            $parent2Chromosome = $population[$listOfCrossover[1]];
            $offspring1 = $this->offspring($parent1Chromosome, $parent2Chromosome, $this->getCutPointIndex(), 1);
            $offspring2 = $this->offspring($parent1Chromosome, $parent2Chromosome, $this->getCutPointIndex(), 2);
            $offsprings[] = $offspring1;
            $offsprings[] = $offspring2;
        }
        return $offsprings;
    }
}