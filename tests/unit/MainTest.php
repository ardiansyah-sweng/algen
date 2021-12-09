<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    function test_runMain_allHappy()
    {
        $main = new Main;
        $main->popSize = 30;
        $main->crossoverRate = 0.8;
        $main->maxGen = 100;
        
        $result = $main->runMain();

        print_r($result);die;
        
    }
}