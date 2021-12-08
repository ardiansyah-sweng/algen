<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    function test_runMain()
    {
        $main = new Main(10, 100, 10000, 0.8);
        $result = $main->runMain();
        print_r($result);die;
        
        if (empty($result)){
            $this->assertEmpty($result);
        } else {
            $this->assertNotEmpty($result);
            $this->assertContainsEquals(0, $result[0]['chromosome']);
        }

    }
}