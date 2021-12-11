<?php

class Miscellaneous
{
    function getNumOfGen($catalogue):int
    {
        $chromosome = new Chromosome($catalogue);
        $chromosomes = $chromosome->createChromosome();
        return count($chromosomes);
    }

    function getCutPointIndex($catalogue):int
    {
        return rand(0, $this->getNumOfGen($catalogue)-1 );
    }
}