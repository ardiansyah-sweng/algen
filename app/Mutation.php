<?php

class Mutation
{
    public $popSize;

    function runMutation(MutationCalculator $mutationCalculator, array $population):array
    {
        $chromosome = new Chromosome;
        $chromosomes = $chromosome->createChromosome(new Catalogue);
        $numOfMutation = $mutationCalculator->calculateNumOfMutation($chromosomes, $this->popSize);

        $ret = [];
        if ($mutationCalculator->isContains($numOfMutation)){
            for ($i = 0; $i < $numOfMutation; $i++){
                $indexOfChromosomes = (new Randomizer())->getRandomIndexOfIndividu($this->popSize);
                $indexOfGen = Randomizer::getRandomIndexOfGen(count($chromosomes));
                $selectedChromosomes = $population[$indexOfChromosomes];
                $valueOfGen = $selectedChromosomes[$indexOfGen];
                $mutatedGen = $mutationCalculator->changeGen($valueOfGen);
                $selectedChromosomes[$indexOfGen] = $mutatedGen;
                $ret[] = $selectedChromosomes;
             }
         }
         return $ret;
    }
}

class MutationCalculator
{
    function calculateMutationRate($chromosomes):float
    {
        return 1 / count($chromosomes);
    }

    function calculateNumOfMutation($chromosomes, $popSize):int
    {
        return round($this->calculateMutationRate($chromosomes) * $popSize);
    }

    function isContains($numOfMutation)
    {
        if ($numOfMutation > 0){
            return true;
        }
    }

    function changeGen($valueOfGen):int
    {
        if ($valueOfGen === 0) {
            return 1;
        } else {
            return 0;
        }
    }
}