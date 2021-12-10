<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    function test_runMain_allHappy()
    {
        $main = new Main;
        $main->popSize = 35;
        $main->crossoverRate = 0.8;
        $main->maxGen = 3;
        $main->selectionType = 'elitism';
        $main->maxBudget = 500000;
        $main->stoppingValue = 100;
        $main->numOfLastResult = 10;
        
        $result = $main->runMain();

        print_r($result);die;
        
    }
}