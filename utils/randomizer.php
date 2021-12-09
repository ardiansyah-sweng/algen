<?php

class Randomizer
{
    static function randomZeroToOneFraction()
    {
        return (float) rand() / (float) getrandmax();
    }

    static function randomVariableValueByRange($variableRanges)
    {
        return mt_rand($variableRanges['lowerBound'] * 100, $variableRanges['upperBound'] * 100) / 100;
    }

    static function getRandomIndexOfIndividu($popSize)
    {
        return rand (0, $popSize-1);
    }

    static function getRandomIndexOfGen($numOfGen)
    {
        return rand (0, $numOfGen-1);
    }
}
