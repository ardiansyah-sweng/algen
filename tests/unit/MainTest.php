<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    function test_runMain()
    {
        $main = new Main;
        $main->popSize = 10;
        $main->crossoverRate = 0.8;
        $result = $main->runMain();
        print_r($result);die;
        
    }
}