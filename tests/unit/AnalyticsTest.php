<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class AnalyticsTest extends TestCase
{
    function test_improvementUnderCertainPercentage()
    {
        $analytics = new Analytics;
        //echo $analytics->improvementUnderCertainPercentage(0.01);

    }
}