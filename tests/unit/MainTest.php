<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    function test_runMain()
    {
        $main = new Main(10, 100, 10000);
        $result = $main->runMain();die;
        
        if (empty($result)){
            $this->assertEmpty($result);
        } else {
            $this->assertNotEmpty($result);
            $this->assertContainsEquals(0, $result[0]['chromosome']);
        }

    }
}