<?php

class Mutation
{
    public $numOfGen;

    function calculateMutationRate():float
    {
        return 1 / $this->numOfGen;
    }

    function calculateNumOfMutation($popSize):int
    {
        return round($this->calculateMutationRate() * $popSize);
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

    function runMutation(array $population, $popSize):array
    {
        $numOfMutation = $this->calculateNumOfMutation($popSize);

        $ret = [];
        if ($this->isContains($numOfMutation)){
            for ($i = 0; $i < $numOfMutation; $i++){
                $indexOfChromosomes = (new Randomizer())->getRandomIndexOfIndividu($popSize);
                $indexOfGen = Randomizer::getRandomIndexOfGen($this->numOfGen);
                $selectedChromosomes = $population[$indexOfChromosomes];
                $valueOfGen = $selectedChromosomes[$indexOfGen];
                $mutatedGen = $this->changeGen($valueOfGen);
                $selectedChromosomes[$indexOfGen] = $mutatedGen;
                $ret[] = $selectedChromosomes;
             }
         }
         return $ret;
    }
}